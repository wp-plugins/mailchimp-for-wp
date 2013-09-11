<?php

class MC4WP_Lite_Admin
{
	private $options = array();

	public function __construct()
	{
		$this->options = MC4WP_Lite::instance()->get_options();

		add_action('admin_init', array($this, 'register_settings'));
		add_action('admin_menu', array($this, 'build_menu'));
		add_action( 'admin_enqueue_scripts', array($this, 'load_css_and_js') );

		register_activation_hook( 'mailchimp-for-wp-pro/mailchimp-for-wp-pro.php', array($this, 'on_activation') );

		add_filter("plugin_action_links_mailchimp-for-wp/mailchimp-for-wp.php", array($this, 'add_settings_link'));
	}

	public function on_activation()
	{
		delete_transient('mc4wp_mailchimp_lists');
		delete_transient('mc4wp_mailchimp_lists_fallback');
	}

	public function add_settings_link($links)
	{
		 $settings_link = '<a href="admin.php?page=mailchimp-for-wp">Settings</a>';
		 $upgrade_link = '<a href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Upgrade to Pro</a>';
         array_unshift($links, $upgrade_link, $settings_link);
         return $links;
	}

	public function register_settings()
	{
		register_setting('mc4wp_options_group', 'mc4wp_lite', array($this, 'validate_options'));
	}

	public function validate_options($opts)
	{
		return $opts;
	}

	public function build_menu()
	{
		$page = add_menu_page('MailChimp for WP Lite', 'MailChimp for WP Lite', 'manage_options', 'mailchimp-for-wp', array($this, 'page_dashboard'), plugins_url('mailchimp-for-wp/img/menu-icon.png'));
	}

	public function load_css_and_js($hook)
	{
		if($hook != 'toplevel_page_mailchimp-for-wp') { return false; }

		wp_register_script('mc4wp-admin-js',  plugins_url('mailchimp-for-wp/js/admin.js'), array('jquery'), false, true);
		
		// css
		wp_enqueue_style( 'mc4wp-admin-css', plugins_url('mailchimp-for-wp/css/admin.css') );

		// js
		wp_enqueue_script( array('jquery', 'mc4wp-admin-js') );
		$translation_array = array( 'admin_page' => get_admin_url(null, 'admin.php?page=mailchimp-for-wp') );
		wp_localize_script( 'mc4wp-admin-js', 'mc4wp_urls', $translation_array );
	}

	public function page_dashboard()
	{
		$opts = $this->options;
		$api = $this->get_mailchimp_api();

		if(empty($opts['mailchimp_api_key'])) {
			$connected = false;
		} else {
			$connected = ($api->ping() === "Everything's Chimpy!");
		}

		if($connected) {
			$lists = $this->get_mailchimp_lists();
		}
		
		// tab shit
		$tabs = array('api-settings', 'checkbox-settings', 'form-settings');
		$tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'api-settings';

		require 'views/dashboard.php';
	}

	private function get_mailchimp_api()
	{
		return MC4WP_Lite::instance()->get_mailchimp_api();
	}

	public function get_mailchimp_lists($refresh_cache = false)
	{
		$lists = get_transient( 'mc4wp_mailchimp_lists' );
		
		$refresh_cache = (isset($_REQUEST['renew-cached-data'])) ? true : $refresh_cache;

		if($refresh_cache || !$lists) {

			// make api request for lists
			$api = $this->get_mailchimp_api();
			$lists_data = $api->lists();
			$lists = array();

			if($lists_data && isset($lists_data['data'])) {

				foreach($lists_data['data'] as $l) {
					$lists[$l['id']] = array(
						'id' => $l['id'],
						'name' => $l['name']
					);
				}

				if(isset($_REQUEST['renew-cached-data'])) {
					// add notice
					add_settings_error("mc4wp", "cache-renewed", 'MailChimp cache renewed.', 'updated' );
				}

				// store lists in transients
				set_transient('mc4wp_mailchimp_lists', $lists, 3600); // 1 hour
				set_transient('mc4wp_mailchimp_lists_fallback', $lists, 1209600); // 2 weeks
			} else {
				// api request failed, get fallback data (with longer lifetime)
				$lists = get_transient('mc4wp_mailchimp_lists_fallback');
				if(!$lists) { return array(); }
			}
			
		}

		return $lists;
	}

}