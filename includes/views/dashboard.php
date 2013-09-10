<div id="mc4wp_admin" class="wrap">

	<h1>MailChimp for WordPress - Configuration</h1>

	<ul id="mc4wp-nav">
		<li><a <?php if($tab == 'api-settings') echo 'class="active"'; ?> data-target="api-settings" href="admin.php?page=mailchimp-for-wp&tab=api-settings">API settings</a></li>
		<li><a <?php if($tab == 'checkbox-settings') echo 'class="active"'; ?> data-target="checkbox-settings" href="admin.php?page=mailchimp-for-wp&tab=checkbox-settings">Checkbox settings</a></li>
		<li><a <?php if($tab == 'form-settings') echo 'class="active"'; ?> data-target="form-settings" href="admin.php?page=mailchimp-for-wp&tab=form-settings">Form settings</a></li>
	</ul>

	<h2 style="display:none;"></h2>
	<?php settings_errors(); ?>

	<div id="mc4wp-main-column">

		<form method="post" action="options.php">
				
			<?php settings_fields( 'mc4wp_options_group' ); ?>

			<div id="mc4wp-tabs">

				<?php 				
					// include tab pages
					foreach($tabs as $t) {
						require "$t.php";
					}
						
				?>

			</div>

		</form>

		<p class="copyright-notice">I would like to remind you that this plugin is not developed by or affiliated with MailChimp in any way.
		 My name is <a href="http://dannyvankooten.com/">Danny van Kooten</a> and I am a young Dutch webdeveloper.</p>
		 <p class="copyright-notice">Enjoying my plugin? Please consider <a href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">upgrading to the premium version</a>, which is awesome.</p>

	</div>

	<div id="mc4wp-secondary-column">
		
		<div class="mc4wp-box" id="mc4wp-upgrade-box">
			<h3>Get MailChimp for WP Pro</h3>
			
			<p>Enjoying the "lite" version of MailChimp for WordPress? You will <strong style="font-size:13px">LOVE</strong> MailChimp for WP Pro.</p>

			<p style="text-align: center;"><a target="_blank" class="upgrade-button" href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Upgrade to MailChimp for WP Pro</a></p>

			<p><strong>Pro features include..</strong>
				<ul>
					<li>AJAX form submission (no page reload)</li>
					<li>Multiple sign-up forms for different lists</li>
					<li>Presets for all your merge fields, easily add new fields</li>
					<li>Log subscribers, gain insight into where and how your visitors subscribe to your lists</li>
					<li>Premium support</li>
				</ul>
			</p>

			<p>Alternative ways to show a token of your appreciation, all much appreciated:</p>
            <ul>
            	<li><a target="_blank" href="http://dannyvankooten.com/donate/">Donate $5, $10 or $20.</a> </li>
                <li><a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/mailchim-for-wp?rate=5#postform">Give a 5&#9733; review on WordPress.org</a></li>
                <li><a target="_blank" href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Link to the plugin page on my website</a></li>
                <li><a target="_blank" href="http://twitter.com/?status=I%20manage%20my%20%23WordPress%20sign-up%20forms%20using%20MailChimp%20for%20WP%20and%20I%20love%20it%20-%20check%20it%20out!%20http%3A%2F%2Fwordpress.org%2Fplugins%2Fmailchimp-for-wp%2F">Tweet about MailChimp for WP</a></li>
            </ul>
        </div>

        <div class="mc4wp-box" id="mc4wp-info-tabs">
			<div class="info-tab info-tab-form-settings" <?php if($tab != 'form-settings') { echo 'style="display:none;"'; } ?>>
				<h4>Notes regarding the form designer</h4>
				<p>At a minimum, your form should include an <strong>EMAIL</strong> field and a submit button.</p>
				
				<p>Add other fields if you like but keep in mind that...</p>
					<ul class="ul-square">
						<li>...all field names should be uppercased</li>
						<li>... field names should match your MailChimp lists merge tags</li>
					</ul>

				<p><strong>Styling</strong></p>
				<p>Alter the visual appearance of the form by applying CSS rules to <b>form.mc4wp-form</b>. Add these CSS rules to your theme's stylesheet
					 which can in most cases be found here: <em><?php echo get_stylesheet_directory(); ?>/style.css</em>.</p>
					 <p>The <a href="http://wordpress.org/plugins/mailchimp-for-wp/faq/" target="_blank">MailChimp for WP FAQ</a> lists the various CSS selectors you can use to target the different elements.</p>
			
				<p><strong>Form variables</strong></p>
				<table class="mc4wp-help">
				<tr>
					<th>{n}</th>
					<td>Replaced with a unique number for this form.</td>
				</tr>
				<tr>
					<th>{ip}</th>
					<td>Replaced with the visitor's IP address.</td>
				</tr>
				<tr>
					<th>{date}</th>
					<td>Replaced with the current date (yyyy/mm/dd eg: <?php echo date("Y/m/d"); ?>)</td>
				</tr>
				<tr>
					<th>{time}</th>
					<td>Replaced with the current time (hh:mm:ss eg: <?php echo date("H:i:s"); ?>)</td>
				</tr>
				<tr>
					<th>{user_email}</th>
					<td>Replaced with the logged in user's email (or nothing, if there is no logged in user).</td>
				</tr>
				<tr>
					<th>{user_name}</th>
					<td>Display name of the current user</td>
				</tr>
				<tr>
					<th>{user_firstname}</th>
					<td>First name of the current user</td>
				</tr>
				<tr>
					<th>{user_lastname}</th>
					<td>Last name of the current user</td>
				</tr>
				<tr>
					<th>{user_id}</th>
					<td>Current user ID</td>
				</tr>
				<tr>
					<th>{current_url}</th>
					<td>Current URL</td>
				</tr>
			</table>

			</div>
		</div>

		<div class="mc4wp-box">
			<h3>Looking for support?</h3>
        	<p>Having trouble? Please use the <a href="http://wordpress.org/support/plugin/mailchimp-for-wp">support forums</a> on WordPress.org.</p>
		</div>

	</div>

	

</div>