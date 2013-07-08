<?php

if(class_exists("MC4WP_RegistrationSubscriber")) { return; }

class MC4WP_RegistrationSubscriber
{
	private $showed_checkbox = false;
	private $options;
	private $mc4wp;

	public function __construct(MC4WP $mc4wp) 
	{
		$this->options = $opts = $mc4wp->get_options();
		$this->mc4wp = $mc4wp;
		
		if($opts['checkbox_show_at_registration_form']) {
			// regular registration actions
			add_action('register_form',array($this, 'output_checkbox'),20);
			add_action('register_post',array($this, 'subscribe'), 50);
		}
		
		if($opts['checkbox_show_at_bp_form']) {
			// BuddyPress actions
			add_action('bp_before_registration_submit_buttons', array($this, 'output_checkbox'), 20);
			add_action('bp_complete_signup', array($this, 'subscribe'), 20);
		}

		if($opts['checkbox_show_at_ms_form']) {
			add_action('signup_extra_fields', array($this, 'output_checkbox'), 20);
			add_action('signup_blogform', array($this, 'add_hidden_checkbox'), 20);

			add_filter('add_signup_meta', array($this, 'add_ms_usermeta'));

			add_action('wpmu_activate_blog', array($this, 'on_ms_blog_signup'), 20, 5);
			add_action('wpmu_activate_user', array($this, 'on_ms_user_signup'), 20, 3);
		}

		if($opts['checkbox_css']) {
			add_action( 'wp_enqueue_scripts', array($this, 'load_stylesheet') );
		}
		
		
	}

	public function load_stylesheet()
	{
		wp_enqueue_style( 'mc4wp-checkbox-reset', plugins_url('mailchimp-for-wp/css/checkbox.css') );
	}

	public function getMC4WP() {
		return $this->mc4wp;
	}

	/**
	* Grab the emailadress (and name) from a regular WP or BuddyPress sign-up and then send this to mailinglist.
	*/
	public function subscribe()
	{
		if($_POST['mc4wp-do-subscribe'] != 1) return;
		
		if(isset($_POST['user_email'])) {
			
			// gather emailadress from user who WordPress registered
			$email = $_POST['user_email'];
			$name = $_POST['user_login'];
		
		} elseif(isset($_POST['signup_email'])) {
		
			// gather emailadress from user who BuddyPress registered
			$email = $_POST['signup_email'];
			$name = $_POST['signup_username'];

		} else { 

			// uh oh
			return false;

		}
		
		$result = $this->getMC4WP()->subscribe($email, array(), array(
			'name' => $name
			)
		);

	}
	

	public function output_checkbox()
	{
		if($this->showed_checkbox) return;

		$opts = $this->options;
		?>
		<p id="mc4wp-checkbox">
			<input value="1" id="mc4wp-checkbox-input" type="checkbox" name="mc4wp-do-subscribe" <?php if(isset($opts['checkbox_precheck']) && $opts['checkbox_precheck'] == 1) echo 'checked="checked" '; ?>/>
			<label for="mc4wp-checkbox-input">
				<?php echo $opts['checkbox_label']; ?>
			</label>
		</p>
		<?php

		$this->showed_checkbox = true;
	}

	public function add_hidden_checkbox()
	{
		?><input type="hidden" name="mc4wp-do-subscribe" value="<?php echo (isset($_POST['mc4wp-do-subscribe'])) ? 1 : 0; ?>" /><?php
	}

	public function add_ms_usermeta($meta)
	{
		$meta['mc4wp-do-subscribe'] = (isset($_POST['mc4wp-do-subscribe'])) ? 1 : 0;
		return $meta;
	}

	public function subscribe_ms_user($user_id)
	{
		$user = get_userdata($user_id);
		
		if(!is_object($user)) return false;

		$email = $user->user_email;
		$name = $user->first_name . ' ' . $user->last_name;
		
		$result = $this->getMC4WP()->subscribe($email, array(
			'name' => $name
			)
		);
	}

	public function on_ms_blog_signup($blog_id, $user_id, $a, $b ,$meta = null)
	{
		if(!isset($meta['mc4wp-do-subscribe']) || $meta['mc4wp-do-subscribe'] != 1) return false;
		
		return $this->subscribe_ms_user($user_id);
	}

	public function on_ms_user_signup($user_id, $password = NULL, $meta = NULL)
	{
		if(!isset($meta['mc4wp-do-subscribe']) || $meta['mc4wp-do-subscribe'] != 1) return false;
		
		return $this->subscribe_ms_user($user_id);
	}

}