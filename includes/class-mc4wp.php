<?php

if(class_exists("MC4WP")) { return; }

class MC4WP 
{
	private static $instance;
	private static $mc_api;
	private $options = array();
	private $defaults = array(
		'mailchimp_api_key' => '', 'mailchimp_lists' => array(), 'mailchimp_double_optin' => 1,
		'checkbox_label' => 'Sign me up for the newsletter!', 'checkbox_precheck' => 1, 'checkbox_css' => 0, 
		'checkbox_show_at_comment_form' => 0, 'checkbox_show_at_registration_form' => 0, 'checkbox_show_at_ms_form' => 0, 'checkbox_show_at_bp_form' => 0
	);

	public static function get_instance()
	{
		if(!isset(self::$instance)) {
			self::$instance = new MC4WP();
		}

		return self::$instance;
	}

	public function __construct()
	{
		$this->options = $opts = array_merge($this->defaults, (array) get_option('mc4wp'));

		if($opts['checkbox_show_at_comment_form']) {
			require 'class-mc4wp-commentsubscriber.php';
			$this->commentSubscriber = new MC4WP_CommentSubscriber($this);
		}

		if($opts['checkbox_show_at_registration_form'] || $opts['checkbox_show_at_bp_form'] || $opts['checkbox_show_at_ms_form']) {
			require 'class-mc4wp-registrationsubscriber.php';
			$this->registrationSubscriber = new MC4WP_RegistrationSubscriber($this);
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

	public function subscribe($email, array $data = array())
	{
		$mc = $this->get_mc_api();
		$opts = $this->get_options();

		$merge_vars = array();

		// add ip address to merge vars
		if(isset($data['ip'])) {
			$merge_vars['OPTINIP'] = $data['ip'];
		}

		if(isset($data['name'])) {
			$name = $data['name'];
			$merge_vars['NAME'] = $name;

			// try to fill first and last name fields as well
			$strpos = strpos($name, ' ');
			$merge_vars['FNAME'] = substr($name, 0, $strpos);
			$merge_vars['LNAME'] = substr($name, $strpos);
		}

		foreach($opts['mailchimp_lists'] as $list) {
			$result = $mc->listSubscribe($list, $email, $merge_vars, 'html', $opts['mailchimp_double_optin']);
		}
		
		// flawed
		// this will only return the result of the last list a subscribe attempt has been sent to
		return $result;
	}

}