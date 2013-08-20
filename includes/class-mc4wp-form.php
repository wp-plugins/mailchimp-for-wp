<?php

class MC4WP_Form
{
	private $options;
	private $form_instance_number = 1;
	private $did_request = false;
	private $request_succes = false; 
	private $error = null;
	private $success = null;

	public function __construct(MC4WP $mc4wp) 
	{
		$this->options = $opts = $mc4wp->get_options();

		if($opts['form_css']) {
			add_action( 'wp_enqueue_scripts', array($this, 'load_stylesheet') );
		}
		
		add_shortcode('mc4wp-form', array($this, 'output_form'));

		// enable shortcodes in text widgets
		add_filter( 'widget_text', 'shortcode_unautop');
		add_filter( 'widget_text', 'do_shortcode', 11);

		if(isset($_POST['mc4wp_form_submit'])) {

			// change $_POST['name'] to something else, to fix WP bug
			// maybe later ok?

			add_action('init', array($this, 'subscribe'));
		}
	}

	public function load_stylesheet()
	{
		wp_enqueue_style( 'mc4wp-form-reset', plugins_url('mailchimp-for-wp/css/form.css') );
	}

	public function output_form($atts, $content = null)
	{
		$mc4wp = MC4WP::get_instance();
		$opts = $this->options;

		// add some useful css classes
		$css_classes = ' ';
		if($this->error) $css_classes .= 'mc4wp-error ';
		if($this->success) $css_classes .= 'mc4wp-success ';

		$content = '<form method="post" action="'. $this->get_current_page_url() .'#mc4wp-form-'. $this->form_instance_number .'" id="mc4wp-form-'.$this->form_instance_number.'" class="mc4wp-form form'.$css_classes.'">';


		// maybe hide the form
		if(!($this->success && $opts['form_hide_after_success'])) {
			$form_markup = $this->options['form_markup'];
			// replace special values
			$form_markup = str_replace('%N%', $this->form_instance_number, $form_markup);
			$form_markup = str_replace('%IP_ADDRESS%', $this->get_ip_address(), $form_markup);
			$form_markup = str_replace('%DATE%', date('dd/mm/yyyy'), $form_markup);

			$content .= $form_markup;

			// hidden fields
			$content .= '<textarea name="mc4wp_required_but_not_really" style="display: none;"></textarea><input type="hidden" name="mc4wp_form_submit" value="1" />';
		}		

		if($this->success) {
			$content .= '<p class="alert success">' . $opts['form_text_success'] . '</p>';
		} elseif($this->error) {
			
			$e = $this->error;

			if($e == 'already_subscribed') {
				$text = (empty($opts['form_text_already_subscribed'])) ? $mc4wp->get_mc_api()->errorMessage : $opts['form_text_already_subscribed'];
				$content .= '<p class="alert notice">'. $text .'</p>';
			}elseif($e == 'no_lists_selected' && current_user_can('manage_options')) {
				$content .= '<p class="alert error"><strong>WP Admins only:</strong> No MailChimp lists have been selected. Go to the MailChimp for WordPress settings page and select at least one list to subscribe to.</p>';
			} elseif(isset($opts['form_text_' . $e]) && !empty($opts['form_text_'. $e] )) {
				$content .= '<p class="alert error">' . $opts['form_text_' . $e] . '</p>';
			} else {
				$content .= '<p class="alert error">' . $opts['form_text_error'];
				
				if(current_user_can('manage_options') && $e == 'merge_field_error') {
					$content .= '<br /><br /><b>Admin only message: </b> there seems to be a problem with one of your merge fields. Maybe you forgot to add a required merge field to your form?';
					$content .= '<br /><br /><b>MailChimp returned the following error: </b><em>'. $mc4wp->get_mc_api()->errorMessage . '</em>';
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
		$mc4wp = MC4WP::get_instance();
		$opts = $this->options; 

		if(!isset($_POST['email']) || !is_email($_POST['email'])) { 
			// no (valid) e-mail address has been given

			$this->error = 'invalid_email';
			$_POST['name'] = null; // wp 404 fix
			return false;
		}

		if(isset($_POST['mc4wp_required_but_not_really']) && !empty($_POST['mc4wp_required_but_not_really'])) {
			// spam bot filled the honeypot field
			$_POST['name'] = null; // wp 404 fix
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

		$_POST['name'] = null; // wp 404 fix


		$result = $mc4wp->subscribe('form', $email, $merge_vars);

		if($result === true) { 
			$this->success = true;

			// check if we want to redirect the visitor
			if(!empty($opts['form_redirect'])) {
				wp_redirect($opts['form_redirect']);
				exit;
			}

			return true;
		} else {

			$this->error = $result;
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