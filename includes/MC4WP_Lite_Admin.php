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

		register_activation_hook( 'mailchimp-for-wp/mailchimp-for-wp.php', array($this, 'on_activation') );

		add_filter("plugin_action_links_mailchimp-for-wp/mailchimp-for-wp.php", array($this, 'add_settings_link'));
	
		// did the user click on upgrade to pro link?
		if(isset($_GET['page']) && $_GET['page'] == 'mc4wp-lite-upgrade' && !headers_sent()) {
			header("Location: http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/");
			exit;
		}
	}

	public function on_activation()
	{
		delete_transient('mc4wp_mailchimp_lists');
		delete_transient('mc4wp_mailchimp_lists_fallback');
	}

	public function add_settings_link($links)
	{
		 $settings_link = '<a href="admin.php?page=mc4wp-lite">Settings</a>';
		 $upgrade_link = '<a href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Upgrade to Pro</a>';
         array_unshift($links, $upgrade_link, $settings_link);
         return $links;
	}

	public function register_settings()
	{
		register_setting('mc4wp_lite_settings', 'mc4wp_lite', array($this, 'validate_options'));
		register_setting('mc4wp_lite_checkbox_settings', 'mc4wp_lite_checkbox', array($this, 'validate_options'));
		register_setting('mc4wp_lite_form_settings', 'mc4wp_lite_form', array($this, 'validate_options'));
	}

	public function validate_options($opts)
	{
		return $opts;
	}

	public function build_menu()
	{
		add_menu_page('MailChimp for WP Lite', 'MailChimp for WP Lite', 'manage_options', 'mc4wp-lite', array($this, 'show_api_settings'), plugins_url('mailchimp-for-wp/assets/img/menu-icon.png'));
		add_submenu_page('mc4wp-lite', 'General Settings - MailChimp for WP Lite', 'General Settings', 'manage_options', 'mc4wp-lite', array($this, 'show_api_settings'));
		add_submenu_page('mc4wp-lite', 'Checkbox Settings - MailChimp for WP Lite', 'Checkbox Settings', 'manage_options', 'mc4wp-lite-checkbox-settings', array($this, 'show_checkbox_settings'));
		add_submenu_page('mc4wp-lite', 'Form Settings - MailChimp for WP Lite', 'Form Settings', 'manage_options', 'mc4wp-lite-form-settings', array($this, 'show_form_settings'));
		add_submenu_page('mc4wp-lite', 'Upgrade to Pro - MailChimp for WP Lite', 'Upgrade to Pro', 'manage_options', 'mc4wp-lite-upgrade', array($this, 'redirect_to_pro'));

	}

	public function load_css_and_js($hook)
	{
		if(!isset($_GET['page']) || stristr($_GET['page'], 'mc4wp-lite') == false) { return; }
		
		// css
		wp_enqueue_style( 'mc4wp-admin-css', plugins_url('mailchimp-for-wp/assets/css/admin.css') );

		// js
		wp_register_script('mc4wp-admin-js',  plugins_url('mailchimp-for-wp/assets/js/admin.js'), array('jquery'), false, true);
		wp_enqueue_script( array('jquery', 'mc4wp-admin-js') );
	}

	public function get_checkbox_compatible_plugins()
	{
		$checkbox_plugins = array(
			'comment_form' => "Comment form",
			"registration_form" => "Registration form"
		);

		if(is_multisite()) $checkbox_plugins['ms_form'] = "MultiSite forms";
		if(class_exists("BuddyPress")) $checkbox_plugins['bp_form'] = "BuddyPress registration";
		if(class_exists('bbPress')) $checkbox_plugins['bbpress_forms'] = "bbPress";

		return $checkbox_plugins;
	}

	public function redirect_to_pro()
	{
		?><script>window.location.replace('http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/'); </script><?php
	}

	public function show_api_settings()
	{
		$opts = $this->options['general'];
		$tab = 'api-settings';

		if(empty($opts['api_key'])) {
			$connected = false;
		} else {
			$connected = (MC4WP_Lite::api()->is_connected());
		}

		$lists = $this->get_mailchimp_lists();
		require 'views/api-settings.php';
	}

	public function show_checkbox_settings()
	{
		$opts = $this->options['checkbox'];
		$lists = $this->get_mailchimp_lists();
		$tab = 'checkbox-settings';
		require 'views/checkbox-settings.php';
	}

	public function show_form_settings()
	{
		$opts = $this->options['form'];
		$lists = $this->get_mailchimp_lists();
		$tab = 'form-settings';
		require 'views/form-settings.php';
	}

	public function get_mailchimp_lists($refresh_cache = false)
	{
		$lists = get_transient( 'mc4wp_mailchimp_lists' );
		
		$refresh_cache = (isset($_REQUEST['mc4wp-renew-cache'])) ? true : $refresh_cache;

		if($refresh_cache || !$lists) {

			// make api request for lists
			$api = MC4WP_Lite::api();
			$connected = $api->is_connected();

			if($connected && ($lists_data = $api->get_lists())) {
				
				// build simplified lists array
				$lists = array();
				foreach($lists_data as $data) {

					$list = array(
						'id' => $data->id,
						'name' => $data->name
					);

					$lists["{$data->id}"] = (object) $list;
				}
				
				if(isset($_REQUEST['mc4wp-renew-cache'])) {
					// add notice
					add_settings_error("mc4wp", "cache-renewed", 'MailChimp cache renewed.', 'updated' );
				}

				// store lists in transients
				set_transient('mc4wp_mailchimp_lists', $lists, (24 * 3600)); // 1 day
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