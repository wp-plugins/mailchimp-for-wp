<?php

if(class_exists("MC4WP_Form")) { return; }

class MC4WP_Form
{
	private $options;
	private $mc4wp;
	private $form_instance_number = 1;
	private $did_request = false;
	private $request_succes = false; 
	private $error = null;
	private $success = null;

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
			add_action('init', array($this, 'subscribe'), 99);
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

		$content = '<form method="post" action="'. $this->get_current_page_url() .'#mc4wp-form" id="mc4wp-form-'.$this->form_instance_number.'" class="mc4wp-form form">';

		$form_markup = $this->options['form_markup'];

		// replace special values
		$form_markup = str_replace('%N%', $this->form_instance_number, $form_markup);
		$form_markup = str_replace('%IP_ADDRESS%', $this->get_ip_address(), $form_markup);
		$form_markup = str_replace('%DATE%', date('dd/mm/yyyy'), $form_markup);

		$content .= $form_markup;

		$content .= '<textarea name="mc4wp_required_but_not_really" style="display: none;"></textarea><input type="hidden" name="mc4wp_form_submit" value="1" />';

		if($this->success) {
			$content .= '<p id="mc4wp-success">' . $opts['form_text_success'] . '</p>';
		} else if($this->error) {

			if(isset($opts['form_text_' . $this->error])) {
				$content .= '<p id="mc4wp-error">' . $opts['form_text_' . $this->error] . '</p>';
			} else {
				$content .= '<p id="mc4wp-error">' . $opts['form_text_error'];
				
				if(current_user_can('manage_options') && $this->error == 'merge_field_error') {
					$content .= '<br /><br /><b>Admin only message: </b> there seems to be a problem with one of your merge fields. Maybe you forgot to add a required merge field to your form?';
					$content .= '<br /><br /><b>MailChimp error: </b><em>'. $this->getMC4WP()->get_mc_api()->errorMessage . '</em>';
				}

				$content .= '</p>';
			}

			
			
		}

		$content .= "</form>";

		// increase form instance number in case there is more than one form on a page
		$this->form_instance_number++;

		return $content;
	}

	public function subscribe()
	{
		$opts = $this->options; 

		if(!isset($_POST['email']) || !is_email($_POST['email'])) { 
			// no (valid) e-mail address has been given

			$this->error = 'invalid_email';
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


		// empty $_POST vars, to prevent strange WP bug
		if(isset($_POST['name'])) { $_POST['name'] = null; }
		if(isset($_POST['email'])) { $_POST['email'] = null; }

		if($result === true) { 
			$this->success = true;

			// check if we want to redirect the visitor
			if(!empty($opts['form_redirect'])) {
				wp_redirect($opts['form_redirect']);
				exit;
			}

			return true;
		} else {
			$this->error = true;
			return false;
		}

		
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