<?php

if(class_exists("MC4WP_Form")) { return; }

class MC4WP_Form
{
	private $options;
	private $mc4wp;
	private $form_instance_number = 1;
	private $did_request = false;
	private $request_succes = false; 
	private $valid_email_address = false;

	public function __construct(MC4WP $mc4wp) 
	{
		$this->options = $opts = $mc4wp->get_options();
		$this->mc4wp = $mc4wp;

		if($opts['form_css']) {
			add_action( 'wp_enqueue_scripts', array($this, 'load_stylesheet') );
		}
		
		add_shortcode('mc4wp-form', array($this, 'output_form'));

		// enable shortcodes in text widgets
		add_filter( 'widget_text', 'shortcode_unautop');
		add_filter( 'widget_text', 'do_shortcode', 11);

		if(isset($_POST['mc4wp_form_submit'])) {
			$this->subscribe();
		}
	}

	public function load_stylesheet()
	{
		wp_enqueue_style( 'mc4wp-form-reset', plugins_url('mailchimp-for-wp/css/form.css') );
	}

	public function getMC4WP() {
		return $this->mc4wp;
	}

	public function output_form($atts, $content = null)
	{
		$opts = $this->options;

		$content = '<form method="post" action="'. $this->get_current_page_url() .'" id="mc4wp-form-'.$this->form_instance_number.'" class="mc4wp-form form">';

		$form_markup = $this->options['form_markup'];

		// replace special values
		$form_markup = str_replace('%N%', $this->form_instance_number, $form_markup);
		$form_markup = str_replace('%IP_ADDRESS%', $this->get_ip_address(), $form_markup);
		$form_markup = str_replace('%DATE%', date('dd/mm/yyyy'), $form_markup);

		$content .= $form_markup;

		$content .= '<textarea name="mc4wp_required_but_not_really" style="display: none;"></textarea><input type="hidden" name="mc4wp_form_submit" value="1" />';

		if($this->did_request) {
			if($this->request_success) {
				$content .= '<p id="mc4wp-success">' . $opts['form_text_success'] . '</p>';
			} elseif(!$this->valid_email_address) {
				$content .= '<p id="mc4wp-error">' . $opts['form_text_invalid_email'] . '</p>';
			} else {
				$content .= '<p id="mc4wp-error">'. $opts['form_text_error'] . '</p>';
			}
		}

		$content .= "</form>";

		// increase form instance number in case there is more than one form on a page
		$this->form_instance_number++;

		return $content;
	}

	public function subscribe()
	{
		if(!isset($_POST['email']) || !is_email($_POST['email'])) { 
			// no (valid) e-mail address has been given
			$this->did_request = true;
			$this->valid_email_address = false;
			return false;
		}

		if(isset($_POST['mc4wp_required_but_not_really']) && !empty($_POST['mc4wp_required_but_not_really'])) {
			// spam bot filled the honeypot field
			return false;
		}

		$email = $_POST['email'];

		// setup merge vars
		$merge_vars = array();

		foreach($_POST as $name => $value) {

			if(in_array($name, array('email', 'mc4wp_required_but_not_really', 'mc4wp_form_submit'))) continue;

			$name = strtoupper($name);
			$merge_vars[$name] = $value;

		}

		$result = $this->getMC4WP()->subscribe($email, $merge_vars);

		$this->did_request = true;
		$this->request_success = $result;
		
		return $result;
	}

	private function get_ip_address()
	{
	    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
	      $ip =  $_SERVER['HTTP_CLIENT_IP'];
	    } elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else {
	      $ip = $_SERVER['REMOTE_ADDR'];
	    }

	    return $ip;
	}

	private function get_current_page_url() {
		$page_url = 'http';

		if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) { $page_url .= 's'; }

		$page_url .= '://';

		if (!isset($_SERVER['REQUEST_URI'])) {
		   	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);
		    if (isset($_SERVER['QUERY_STRING'])) { $_SERVER['REQUEST_URI'] .='?'.$_SERVER['QUERY_STRING']; }
		}

		if($_SERVER['SERVER_PORT'] != '80') {
			$page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$page_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}

 		return $page_url;
}


	

	

}