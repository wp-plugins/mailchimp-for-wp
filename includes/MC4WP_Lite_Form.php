<?php

class MC4WP_Lite_Form
{
	private $options;
	private $form_instance_number = 1;
	private $error = null;
	private $success = false;
	private $submitted_form_instance = 0;

	public function __construct() 
	{
		$this->options = $opts = MC4WP_Lite::instance()->get_options();

		if($opts['form_css']) {
			add_action( 'wp_enqueue_scripts', array($this, 'load_stylesheet') );
		}
		
		add_shortcode('mc4wp-form', array($this, 'output_form'));

		// enable shortcodes in text widgets
		add_filter( 'widget_text', 'shortcode_unautop');
		add_filter( 'widget_text', 'do_shortcode', 11);

		if(isset($_POST['mc4wp_form_submit'])) {
			$this->ensure_backwards_compatibility();
			add_action('init', array($this, 'submit'));
		}

		
	}

	public function load_stylesheet()
	{
		wp_enqueue_style( 'mc4wp-form-reset', plugins_url('mailchimp-for-wp/css/form.css') );
	}

	public function output_form($atts, $content = null)
	{
		$opts = $this->options;

		// add some useful css classes
		$css_classes = ' ';
		if($this->error) $css_classes .= 'mc4wp-form-error ';
		if($this->success) $css_classes .= 'mc4wp-form-success ';

		$content = '<!-- Form by MailChimp for WP plugin v'. MC4WP_LITE_VERSION .' - http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/ -->';
		$content .= '<form method="post" action="'. $this->get_current_url() .'#mc4wp-form-'. $this->form_instance_number .'" id="mc4wp-form-'.$this->form_instance_number.'" class="mc4wp-form form'.$css_classes.'">';


		// maybe hide the form
		if(!($this->success && $opts['form_hide_after_success'])) {
			$form_markup = __($this->options['form_markup']);
			// replace special values
			$form_markup = $this->replace_form_variables($form_markup);

			$content .= $form_markup;

			// hidden fields
			$content .= '<textarea name="mc4wp_required_but_not_really" style="display: none;"></textarea>';
			$content .= '<input type="hidden" name="mc4wp_form_submit" value="1" />';
			$content .= '<input type="hidden" name="mc4wp_form_instance" value="'. $this->form_instance_number .'" />';
		}		


		if($this->form_instance_number == $this->submitted_form_instance) {
			
			if($this->success) {
				$content .= '<div class="mc4wp-alert mc4wp-success">' . __($opts['form_text_success']) . '</div>';
			} elseif($this->error) {

				$api = MC4WP_Lite::instance()->get_mailchimp_api();
				$e = $this->error;

				if($e == 'already_subscribed') {
					$text = (empty($opts['form_text_already_subscribed'])) ? $api->errorMessage : $opts['form_text_already_subscribed'];
					$content .= '<div class="mc4wp-alert mc4wp-notice">'. __($text) .'</div>';
				} elseif(isset($opts['form_text_' . $e]) && !empty($opts['form_text_'. $e] )) {
					$content .= '<div class="mc4wp-alert mc4wp-error">' . __($opts['form_text_' . $e]) . '</div>';
				}

				if(current_user_can('manage_options')) {

					if($api->errorCode && !empty($api->errorMessage)) {
						$content .= '<div class="mc4wp-alert mc4wp-error"><strong>Admin notice:</strong> '. $api->errorMessage . '</div>';
					}	
				} 

			}
			// endif
		}

		if(current_user_can('manage_options') && empty($opts['form_lists'])) {
			$content .= '<div class="mc4wp-alert mc4wp-error"><strong>Admin notice:</strong> you have not selected a MailChimp list for this sign-up form to subscribe to yet. <a href="'. get_admin_url(null, 'admin.php?page=mailchimp-for-wp&tab=form-settings') .'">Edit your form settings</a> and select at least 1 list.</div>';
		}

		$content .= "</form>";
		$content .= '<!-- / MailChimp for WP Plugin -->';

		// increase form instance number in case there is more than one form on a page
		$this->form_instance_number++;

		return $content;
	}

	public function submit()
	{
		$opts = $this->options; 
		$this->submitted_form_instance = (int) $_POST['mc4wp_form_instance'];

		if(!isset($_POST['EMAIL']) || !is_email($_POST['EMAIL'])) { 
			// no (valid) e-mail address has been given

			$this->error = 'invalid_email';
			return false;
		}

		if(isset($_POST['mc4wp_required_but_not_really']) && !empty($_POST['mc4wp_required_but_not_really'])) {
			// spam bot filled the honeypot field
			return false;
		}

		$email = $_POST['EMAIL'];

		// setup merge vars
		$merge_vars = array();

		foreach($_POST as $name => $value) {

			// only add uppercases fields to merge variables array
			if(!empty($name) && $name == 'EMAIL' || $name !== strtoupper($name)) { continue; }

			if($name === 'GROUPINGS') {

				$groupings = $value;

				// malformed
				if(!is_array($groupings)) { continue; }

				// setup groupings array
				$merge_vars['GROUPINGS'] = array();

				foreach($groupings as $grouping_id_or_name => $groups) {

						$grouping = array();

						if(is_numeric($grouping_id_or_name)) {
							$grouping['id'] = $grouping_id_or_name;
						} else {
							$grouping['name'] = $grouping_id_or_name;
						}

						if(is_array($groups)) {
							$grouping['groups'] = implode(',', $groups);
						} else {
							$grouping['groups'] = $groups;
						}

							// add grouping to array
						$merge_vars['GROUPINGS'][] = $grouping;
				}

				if(empty($merge_vars['GROUPINGS'])) { unset($merge_vars['GROUPINGS']); }

			} else {
				$merge_vars[$name] = $value;
			}

		}

		$result = $this->subscribe($email, $merge_vars);

		if($result === true) { 
			$this->success = true;

			// check if we want to redirect the visitor
			if(!empty($opts['form_redirect'])) {
				wp_redirect($opts['form_redirect']);
				exit;
			}

			return true;
		} else {

			$this->success = false;
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

	private function get_current_url() {
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

	/*
		Ensure backwards compatibility so sign-up forms that contain old form mark-up rules don't break
		- Uppercase $_POST variables that should be sent to MailChimp
		- Format GROUPINGS in one of the following formats. 
			$_POST[GROUPINGS][$group_id] = "Group 1, Group 2"
			$_POST[GROUPINGS][$group_name] = array("Group 1", "Group 2")
	*/
	public function ensure_backwards_compatibility()
	{

		// upercase $_POST variables
		foreach($_POST as $name => $value) {
			
			// only uppercase variables which are not already uppercased, skip mc4wp internal vars
			if($name === strtoupper($name) || in_array($name, array('mc4wp_form_instance', 'mc4wp_required_but_not_really', 'mc4wp_form_submit'))) continue;
			$uppercased_name = strtoupper($name);

			// set new (uppercased) $_POST variable, unset old one.
			$_POST[$uppercased_name] = $value;
			unset($_POST[$name]);			
		}

		// detect old style GROUPINGS, then fix it.
		if(isset($_POST['GROUPINGS']) && is_array($_POST['GROUPINGS']) && isset($_POST['GROUPINGS'][0])) {

			$old_groupings = $_POST['GROUPINGS'];
			unset($_POST['GROUPINGS']);
			$new_groupings = array();

			foreach($old_groupings as $grouping) {

				if(!isset($grouping['id']) && !isset($grouping['name'])) { continue; }

				$key = (isset($grouping['id'])) ? $grouping['id'] : $grouping['name'];

				$new_groupings[$key] = $grouping['groups'];

			}

			// re-fill $_POST array with new groupings
			if(!empty($new_groupings)) { $_POST['GROUPINGS'] = $new_groupings; }

		}

		return;
	}

	public function subscribe($email, array $merge_vars = array())
	{
		$api = MC4WP_Lite::instance()->get_mailchimp_api();
		$opts = $this->options;

		$lists = $opts['checkbox_lists'];
		
		if(empty($lists)) {
			return 'no_lists_selected';
		}

		// guess FNAME and LNAME
		if(isset($merge_vars['NAME']) && !isset($merge_vars['FNAME']) && !isset($merge_vars['LNAME'])) {
			
			$strpos = strpos($name, ' ');

			if($strpos) {
				$merge_vars['FNAME'] = substr($name, 0, $strpos);
				$merge_vars['LNAME'] = substr($name, $strpos);
			} else {
				$merge_vars['FNAME'] = $name;
			}
		}
		
		foreach($lists as $list) {
			$result = $api->listSubscribe($list, $email, $merge_vars, 'html', $opts['checkbox_double_optin']);
		}

		if($api->errorCode) {

			if($api->errorCode == 214) {
				return 'already_subscribed';
			}

			return 'error';
		}
		
		// flawed
		// this will only return the result of the last list a subscribe attempt has been sent to
		return $result;
	}

	private function replace_form_variables($markup) 
	{

		$markup = str_replace(array('%N%', '{n}'), $this->form_instance_number, $markup);
		$markup = str_replace(array('%IP_ADDRESS%', '{ip}'), $this->get_ip_address(), $markup);
		$markup = str_replace(array('%DATE%', '{date}'), date('Y/m/d'), $markup);
		$markup = str_replace('{time}', date("H:i:s"), $markup);
		$markup = str_replace('{current_url}', $this->get_current_url(), $markup);
		
		$needles = array('{user_email}', '{user_firstname}', '{user_lastname}', '{user_name}', '{user_id}');
		if(is_user_logged_in()) {
			// logged in user, replace vars by user vars
			$user = wp_get_current_user();
			$replacements = array($user->user_email, $user->user_firstname, $user->user_lastname, $user->display_name, $user->ID);
        	$markup = str_replace($needles, $replacements, $markup);
    	} else {
    		// no logged in user, remove vars
    		$markup = str_replace($needles, '', $markup);
    	}

		return $markup;
	}

}