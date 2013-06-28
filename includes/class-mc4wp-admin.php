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
		add_action( 'bp_include', array($this, 'set_buddypress_var'));
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
		$page = add_menu_page('MailChimp for WP', 'MailChimp for WP', 'manage_options', 'mailchimp-for-wp', array($this, 'page_dashboard'));
		add_action( 'admin_print_styles-' . $page, array($this, 'load_css') );
	}

	public function load_css()
	{
		wp_enqueue_style( 'mc4wp_css', plugins_url('mailchimp-for-wp/css/admin.css') );
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
		
		var_dump($this->runs_buddypress);

		require 'views/dashboard.php';
	}

	public function set_buddypress_var()
	{
		$this->runs_buddypress = true;
	}
}