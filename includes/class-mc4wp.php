<?php

if(class_exists("MC4WP")) { return; }

class MC4WP 
{
	private static $instance;
	private static $mc_api;
	private $options = array();

	public static function get_instance()
	{
		if(!isset(self::$instance)) {
			self::$instance = new MC4WP();
		}

		return self::$instance;
	}

	public function __construct()
	{
		$defaults = array(
			'mailchimp_api_key' => '', 'mailchimp_lists' => array(), 'mailchimp_double_optin' => 1,
			'checkbox_label' => 'Sign me up for the newsletter!', 'checkbox_precheck' => 1, 'checkbox_css' => 0, 
			'checkbox_show_at_comment_form' => 0, 'checkbox_show_at_registration_form' => 0, 'checkbox_show_at_ms_form' => 0, 'checkbox_show_at_bp_form' => 0,
			'form_usage' => 0, 'form_css' => 0, 'form_markup' => "<p>\n\t<label for=\"mc4wp_f%N%_email\">Email address: </label>\n\t<input type=\"email\" id=\"mc4wp_f%N%_email\" name=\"email\" required placeholder=\"Your email address\" />\n</p>\n\n<p>\n\t<input type=\"submit\" value=\"Sign up\" />\n</p>",
			'form_text_success' => 'Thank you, your sign-up request was succesful! Please check your e-mail inbox.', 'form_text_error' => 'Oops. Something went wrong. Please try again later.',
			'form_text_invalid_email' => 'Please provide a valid email address.', 'form_text_already_subscribed' => "Given email address is already subscribed, thank you!", 
			'form_redirect' => ''
		);

		$this->options = $opts = array_merge($defaults, (array) get_option('mc4wp'));

		if($opts['checkbox_show_at_comment_form']) {
			require 'class-mc4wp-commentsubscriber.php';
			$this->commentSubscriber = new MC4WP_CommentSubscriber($this);
		}

		if($opts['checkbox_show_at_registration_form'] || $opts['checkbox_show_at_bp_form'] || $opts['checkbox_show_at_ms_form']) {
			require 'class-mc4wp-registrationsubscriber.php';
			$this->registrationSubscriber = new MC4WP_RegistrationSubscriber($this);
		}

		if($opts['form_usage']) {
			require 'class-mc4wp-form.php';
			$this->form = new MC4WP_Form($this);
		}
	}

	public function get_options() 
	{
		return $this->options;
	}

	public function get_mc_api()
	{
		if(!isset(self::$mc_api)) {
			require_once 'class-MCAPI.php';
			self::$mc_api = new MCAPI($this->options['mailchimp_api_key']);
		}

		return self::$mc_api;
	}

	public function subscribe($email, array $merge_vars = array(), array $data = array())
	{
		$mc = $this->get_mc_api();
		$opts = $this->get_options();

		// add ip address to merge vars
		if(isset($data['ip'])) {
			$merge_vars['OPTINIP'] = $data['ip'];
		}

		// guess all three name kinds
		if(isset($data['name'])) {
			
			$name = $data['name'];
			$merge_vars['NAME'] = $name;

			if(!isset($merge_vars['FNAME']) && !isset($merge_vars['LNAME'])) {
				// try to fill first and last name fields as well
				$strpos = strpos($name, ' ');

				if($strpos) {
					$merge_vars['FNAME'] = substr($name, 0, $strpos);
					$merge_vars['LNAME'] = substr($name, $strpos);
				} else {
					$merge_vars['FNAME'] = $name;
					$merge_vars['LNAME'] = '...';
				}
			}
		}

		foreach($opts['mailchimp_lists'] as $list) {
			$result = $mc->listSubscribe($list, $email, $merge_vars, 'html', $opts['mailchimp_double_optin']);
		}

		if($mc->errorCode) {

			if($mc->errorCode == 214) {
				return 'already_subscribed';
			}

			if($mc->errorCode >= 250 && $mc->errorCode <= 254 && current_user_can('manage_options')) {
				return 'merge_field_error';
			}

			return false;
		}
		
		// flawed
		// this will only return the result of the last list a subscribe attempt has been sent to
		return $result;
	}


}