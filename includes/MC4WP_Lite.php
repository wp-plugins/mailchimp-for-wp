<?php

class MC4WP_Lite
{
	private $options = array();
	private $mailchimp_api = null;
	private static $instance, $checkbox = null, $form = null;

	public static function instance()
	{
		return self::$instance;
	}

	public static function checkbox()
	{
		if(!self::$checkbox) { 
			require 'MC4WP_Lite_Checkbox.php';
			self::$checkbox = new MC4WP_Lite_Checkbox(); 
		}
		return self::$checkbox;
	}

	public static function form()
	{
		if(!self::$form) { 
			require 'MC4WP_Lite_Form.php';
			self::$form = new MC4WP_Lite_Form(); 
		}
		return self::$form;
	}

	public function __construct()
	{
		self::$instance = $this;

		$opts = $this->get_options();

		if($opts['checkbox_show_at_comment_form'] || $opts['checkbox_show_at_registration_form'] || $opts['checkbox_show_at_bp_form'] || $opts['checkbox_show_at_ms_form'] || $opts['checkbox_show_at_other_forms']) {
			self::checkbox();
		}

		// load form functionality
		if($opts['form_usage']) {
			self::form();
		}

		if(defined('DOING_AJAX') && DOING_AJAX) {
			// ajax only

		} else {
			// non-ajax only

			if(is_admin()) {
				// backend non-ajax only
				require_once 'MC4WP_Lite_Admin.php';
				new MC4WP_Lite_Admin();
			} else {
				// frontend non-ajax only
				require 'functions.php';
			}
		}
	}

	public function get_options() 
	{
		if(empty($this->options)) {
			$defaults = array(
				'mailchimp_api_key' => '',
				'checkbox_label' => 'Sign me up for the newsletter!', 'checkbox_precheck' => 1, 'checkbox_css' => 0, 
				'checkbox_show_at_comment_form' => 0, 'checkbox_show_at_registration_form' => 0, 'checkbox_show_at_ms_form' => 0, 'checkbox_show_at_bp_form' => 0, 'checkbox_show_at_other_forms' => 0,
				'checkbox_lists' => array(), 'checkbox_double_optin' => 1,
				'form_usage' => 0, 'form_css' => 1, 'form_markup' => "<p>\n\t<label for=\"mc4wp_email\">Email address: </label>\n\t<input type=\"email\" id=\"mc4wp_email\" name=\"EMAIL\" required placeholder=\"Your email address\" />\n</p>\n\n<p>\n\t<input type=\"submit\" value=\"Sign up\" />\n</p>",
				'form_text_success' => 'Thank you, your sign-up request was successful! Please check your e-mail inbox.', 'form_text_error' => 'Oops. Something went wrong. Please try again later.',
				'form_text_invalid_email' => 'Please provide a valid email address.', 'form_text_already_subscribed' => "Given email address is already subscribed, thank you!", 
				'form_redirect' => '', 'form_lists' => array(), 'form_double_optin' => 1, 'form_hide_after_success' => 0
			);
	
			$options = get_option('mc4wp_lite');
			if(!$options) {
				// using old option key?
				if(($options = get_option('mc4wp')) != false) {
					add_option('mc4wp_lite', $options);
				}
			}

			$this->options = $opts = array_merge($defaults, (array) $options);
		}

		return $this->options;
	}

	public function get_mailchimp_api()
	{
		if(!$this->mailchimp_api) {

			// Only load MailChimp API if it has not been loaded yet
			// other plugins may have already at this point.
			if(!class_exists("MCAPI")) {
				require_once 'MCAPI.php';
			}
			
			$this->mailchimp_api = new MCAPI($this->options['mailchimp_api_key']);
		}

		return $this->mailchimp_api;
	}

}