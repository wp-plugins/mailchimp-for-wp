<?php

if(class_exists("MC4WP_Admin")) { return; }

class MC4WP_Admin
{
	private static $instance;
	private $MC4WP;
	private $options = array();
	private $runs_buddypress = false;

	public function __construct(MC4WP $MC4WP)
	{
		$this->MC4WP = $MC4WP;
		$this->options = $MC4WP->get_options();

		add_action('admin_init', array($this, 'register_settings'));
		add_action('admin_menu', array($this, 'build_menu'));
		add_action( 'admin_enqueue_scripts', array($this, 'load_css_and_js') );
		add_action( 'bp_include', array($this, 'set_buddypress_var'));

		add_filter("plugin_action_links_mailchimp-for-wp/mailchimp-for-wp.php", array($this, 'add_settings_link'));
	}

	public function add_settings_link($links)
	{
		 $settings_link = '<a href="admin.php?page=mailchimp-for-wp">Settings</a>';
         array_unshift($links, $settings_link);
         return $links;
	}

	public function register_settings()
	{
		register_setting('mc4wp_options_group', 'mc4wp', array($this, 'validate_options'));
	}

	public function validate_options($options)
	{
		return $options;
	}

	public function build_menu()
	{
		$page = add_menu_page('MailChimp for WP', 'MailChimp for WP', 'manage_options', 'mailchimp-for-wp', array($this, 'page_dashboard'), plugins_url('mailchimp-for-wp/img/menu-icon.png'));
	}

	public function load_css_and_js($hook)
	{
		if($hook != 'toplevel_page_mailchimp-for-wp') { return false; }

		wp_register_script('mc4wp-js',  plugins_url('mailchimp-for-wp/js/admin.js'), array('jquery'), false, true);
		wp_register_script('twitter-widgets', 'http://platform.twitter.com/widgets.js', null, false, true);
		// css
		wp_enqueue_style( 'mc4wp-css', plugins_url('mailchimp-for-wp/css/admin.css') );

		// js
		wp_enqueue_script( array('jquery', 'mc4wp-js', 'twitter-widgets') );
		$translation_array = array( 'admin_page' => get_admin_url(null, 'admin.php?page=mailchimp-for-wp') );
		wp_localize_script( 'mc4wp-js', 'mc4wp_urls', $translation_array );
	}

	public function page_dashboard()
	{
		$opts = $this->options;
		$api = $this->MC4WP->get_mc_api();
		$runs_buddypress = $this->runs_buddypress;

		$connected = ($api->ping() === "Everything's Chimpy!");

		if($connected) {
			$lists = $api->lists();
		}
		
		// tab shit
		$tabs = array('api-settings', 'mailchimp-settings', 'checkbox-settings', 'form-settings');
		$tab = (isset($_GET['tab'])) ? $_GET['tab'] : 'api-settings';

		require 'views/dashboard.php';
	}

	public function set_buddypress_var()
	{
		$this->runs_buddypress = true;
	}
}