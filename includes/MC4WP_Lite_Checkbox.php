<?php

class MC4WP_Lite_Checkbox
{
	private $options = array();
	private $showed_checkbox = false;

	public function __construct()
	{
		$this->options = $opts = MC4WP_Lite::instance()->get_options();

		// load checkbox css if necessary
		if($this->options['checkbox_css'] == 1) {
			add_action( 'wp_enqueue_scripts', array($this, 'load_stylesheet') );
			add_action( 'login_enqueue_scripts',  array($this, 'load_stylesheet') );
		}

		/* Comment Form Actions */
		if($opts['checkbox_show_at_comment_form']) {
			add_action ('comment_post', array($this, 'add_comment_meta'), 1);
		
			// hooks for checking if we should subscribe the commenter
			add_action('comment_approved_', array($this, 'subscribe_from_comment'), 10, 1);
			add_action('comment_post', array($this, 'subscribe_from_comment'), 60, 1);

			// hooks for outputting the checkbox
			add_action('thesis_hook_after_comment_box', array($this,'output_checkbox'), 20);
			add_action('comment_form', array($this,'output_checkbox'), 20);
		}

		/* Registration Form Actions */
		if($opts['checkbox_show_at_registration_form']) {
			add_action('register_form',array($this, 'output_checkbox'),20);
			add_action('user_register',array($this, 'subscribe_from_registration'), 50);
		}

		/* BuddyPress Form Actions */
		if($opts['checkbox_show_at_bp_form']) {
			add_action('bp_before_registration_submit_buttons', array($this, 'output_checkbox'), 20);
			add_action('bp_complete_signup', array($this, 'subscribe_from_buddypress'), 20);
		}

		/* Multisite Form Actions */
		if($opts['checkbox_show_at_ms_form']) {
			add_action('signup_extra_fields', array($this, 'output_checkbox'), 20);
			add_action('signup_blogform', array($this, 'add_multisite_hidden_checkbox'), 20);
			add_action('wpmu_activate_blog', array($this, 'on_multisite_blog_signup'), 20, 5);
			add_action('wpmu_activate_user', array($this, 'on_multisite_user_signup'), 20, 3);

			add_filter('add_signup_meta', array($this, 'add_multisite_usermeta'));
		}

		/* Other actions... catch-all */
		if($opts['checkbox_show_at_other_forms']) {
			add_action('init', array($this, 'add_cf7_shortcode')); 
			add_action('init', array($this, 'subscribe_from_whatever'));
		}

	}

	public function add_cf7_shortcode()
	{
		if(function_exists("wpcf7_add_shortcode")) {
			wpcf7_add_shortcode('mc4wp_checkbox', array($this, 'get_checkbox'));
		}
	}

	public function get_checkbox()
	{
		$opts = $this->options;
		$checked = $opts['checkbox_precheck'] ? "checked" : '';
		$content = '<p id="mc4wp-checkbox">';
		$content .= '<input type="checkbox" name="mc4wp-do-subscribe" id="mc4wp-checkbox-input" value="1" '. $checked . ' />';
		$content .= '<label for="mc4wp-checkbox-input">'. __($opts['checkbox_label']) . '</label>';
		$content .= '</p>';
		return $content;
	}

	public function output_checkbox()
	{
		if($this->showed_checkbox) return;
		echo $this->get_checkbox();
		$this->showed_checkbox = true;
	}

	public function load_stylesheet()
	{
		wp_enqueue_style( 'mc4wp-checkbox-reset', plugins_url('mailchimp-for-wp/css/checkbox.css') );
	}


	/* Start comment form functions */
	public function subscribe_from_comment($cid, $comment = null)
	{
		$cid = (int) $cid;
		$opts = $this->options;
		$mc4wp = MC4WP_Lite::instance();
	
		if ( !is_object($comment) )
			$comment = get_comment($cid);
		
		// check if comment has been marked as spam or not
		if ( $comment->comment_karma == 0 ) {

			// check if commenter wanted to be subscribed
			$subscribe = get_comment_meta($cid, 'mc4wp_subscribe', true);

			if($subscribe == 1) {
				$email = $comment->comment_author_email;
				$merge_vars = array(
					'OPTINIP' => $comment->comment_author_IP,
					'NAME' => $comment->comment_author
				);

				$result = $this->subscribe($email, $merge_vars);

				if($result === true) {
					update_comment_meta($cid, 'mc4wp_subscribe', 'subscribed', 1);
				} else {
					// something went wrong
					$error = $result;
				}

			}
		}
	}

	public function add_comment_meta($comment_id)
	{
		 add_comment_meta($comment_id, 'mc4wp_subscribe', $_POST['mc4wp-do-subscribe'], true );
	}
	/* End comment form functions */

	/* Start registration form functions */
	public function subscribe_from_registration($user_id)
	{
		if($_POST['mc4wp-do-subscribe'] != 1) { return false; }
			
		// gather emailadress from user who WordPress registered
		$user = get_userdata($user_id);
		if(!$user) { return false; }

		$email = $user->user_email;
		$merge_vars = array(
			'NAME' => $user->user_login
		);
		
		$result = $this->subscribe($email, $merge_vars); 
	}
	/* End registration form functions */

	/* Start BuddyPress functions */
	public function subscribe_from_buddypress()
	{
		$mc4wp = MC4WP_Lite::instance();

		if($_POST['mc4wp-do-subscribe'] != 1) return;
			
		// gather emailadress and name from user who BuddyPress registered
		$email = $_POST['signup_email'];
		$merge_vars = array(
			'NAME' => $_POST['signup_username']
		);

		$result = $this->subscribe($email, $merge_vars);
	}
	/* End BuddyPress functions */

	/* Start Multisite functions */
	public function add_multisite_hidden_checkbox()
	{
		?><input type="hidden" name="mc4wp-do-subscribe" value="<?php echo (isset($_POST['mc4wp-do-subscribe'])) ? 1 : 0; ?>" /><?php
	}

	public function on_multisite_blog_signup($blog_id, $user_id, $a, $b ,$meta = null)
	{
		if(!isset($meta['mc4wp-do-subscribe']) || $meta['mc4wp-do-subscribe'] != 1) return false;
		
		return $this->subscribe_from_multisite($user_id);
	}

	public function on_multisite_user_signup($user_id, $password = NULL, $meta = NULL)
	{
		if(!isset($meta['mc4wp-do-subscribe']) || $meta['mc4wp-do-subscribe'] != 1) return false;
		
		return $this->subscribe_from_multisite($user_id);
	}

	public function add_multisite_usermeta($meta)
	{
		$meta['mc4wp-do-subscribe'] = (isset($_POST['mc4wp-do-subscribe'])) ? 1 : 0;
		return $meta;
	}

	public function subscribe_from_multisite($user_id)
	{
		$user = get_userdata($user_id);
		
		if(!is_object($user)) return false;

		$email = $user->user_email;
		$merge_vars = array(
			'NAME' => $user->first_name . ' ' . $user->last_name
		);
		$result = $this->subscribe($email, $merge_vars);
	}
	/* End Multisite functions */

	/* Start whatever functions */
	public function subscribe_from_whatever()
	{
		if(!isset($_POST['mc4wp-do-subscribe']) || !$_POST['mc4wp-do-subscribe']) { return false; }

		// check if not coming from a comment form, registration form, buddypress form or multisite form. 
		$script_filename = basename($_SERVER["SCRIPT_FILENAME"]);
		if(in_array( $script_filename, array('wp-comments-post.php', 'wp-login.php', 'wp-signup.php'))) { return false; }
		if(isset($_POST['signup_submit'])) { return false; }

		// start running..
		$opts = $this->options;
		$email = null;
		$merge_vars = array();

		// Smart field guessing
		$possibilities = array('email', 'your-email', 'e-mail', 'emailaddress', 'user_email', 'signup_email', 'emailadres', 'your_email');
		foreach($possibilities as $key) {
			if(isset($_POST[$key]) && !empty($_POST[$key])) {
				$email = $_POST[$key];
				break;
			}
		}

		$possibilities = array('name', 'your-name', 'username', 'fname', 'user_login', 'lname', 'first_name', 'last_name', 'firstname', 'lastname', 'fullname', 'naam');
		foreach($possibilities as $key) {
			if(isset($_POST[$key]) && !empty($_POST[$key])) {
				$merge_vars['NAME'] = $_POST[$key];
				break;
			}
		}

		// if email has not been found by the smart field guessing, return false.. sorry
		if(!$email) { 
			if(current_user_can('manage_options')) {
				die("
					<h3>MailChimp for WP error</h3>
					<p>MailChimp for WP detected a subscribe attempt but had some trouble determining the email value. Make sure the other form contains an e-mail field with
					 one of the following name attributes: 'email', 'e-mail', 'emailaddress', 'user_email', 'signup_email' or 'emailadres'.</p>
				");
			}
			return false; 
		}

		// subscribe
		$result = $this->subscribe($email, $merge_vars);
		return true;
	}
	/* End whatever functions */

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

}