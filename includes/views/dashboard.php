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

		<p class="copyright-notice">I would like to remind you that this plugin is <b>not</b> developed by or affiliated with MailChimp in any way. My name is <a href="http://dannyvankooten.com/">Danny van Kooten</a>, I am a young, Dutch webdeveloper who thought more people might like a plugin like this one.</p>

	</div>

	<div id="mc4wp-secondary-column">
		
		<div id="mc4wp-upgrade-box">
			<h3>Get MailChimp for WP Pro</h3>
			
			<p>Enjoying the "lite" version of MailChimp for WordPress? You will <strong style="font-size:13px">LOVE</strong> MailChimp for WP Pro.</p>

			<p style="text-align: center;"><a target="_blank" class="upgrade-button" href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Upgrade to MailChimp for WP Pro</a></p>

			<p>Pro features include..
				<ul>
					<li>AJAX form submission (no page reload)</li>
					<li>Multiple sign-up forms</li>
					<li>Even easier form creation</li>
					<li>Premium support</li>
				</ul>
			</p>

			<p>Alternatively, you can: </p>
            <ul>
            	<li><a target="_blank" href="http://dannyvankooten.com/donate/">Donate $5, $10 or $20</a> <small>(just buy Pro)</small></li>
                <li><a target="_blank" href="http://wordpress.org/support/view/plugin-reviews/mailchim-for-wp?rate=5#postform">Give a 5&#9733; review on WordPress.org</a></li>
                <li><a target="_blank" href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Link to the plugin page on my website</a></li>
                <li><a target="_blank" href="http://twitter.com/?status=I%20manage%20my%20%23WordPress%20sign-up%20forms%20using%20MailChimp%20for%20WP%20and%20I%20love%20it%20-%20check%20it%20out!%20http%3A%2F%2Fwordpress.org%2Fplugins%2Fmailchimp-for-wp%2F">Tweet about MailChimp for WP</a></li>
            </ul>
        </div>

        <div id="mc4wp-info-tabs">
			<div class="info-tab info-tab-form-settings" <?php if($tab != 'form-settings') { echo 'style="display:none;"'; } ?>>
				<h4>Notes regarding the form designer</h4>
				<p>At a minimum, your form should include an EMAIL field and a submit button.</p>
				
				<p>Add other fields if you like but keep in mind that...</p>
					<ul class="ul-square">
						<li>...all field names should be uppercased</li>
						<li>... field names should match your MailChimp lists merge fields tags</li>
					</ul>


				<p><strong>Special form strings</strong></p>
				<table>
					<tr>
						<th>%N%</th><td>The form instance number. Useful when you have more than one form on a certain page.</td>
					</tr>
					<tr>
						<th>%IP_ADDRESS%</th><td>The IP adress of the visitor.</td>
					</tr>
					<tr>
						<th>%DATE%</th><td>The current date (dd/mm/yyyy).</td>
					</tr>
				</table>

				<p><strong>Visual appearance</strong></p>
				<p>Alter the visual appearance of the form by applying CSS rules to <b>form.mc4wp-form</b>. Add these CSS rules to your theme's stylesheet
					 which can in most cases be found here: <em><?php echo get_stylesheet_directory(); ?>/style.css</em>.</p>
					 <p>The <a href="http://wordpress.org/plugins/mailchimp-for-wp/faq/" target="_blank">MailChimp for WP FAQ</a> lists the various CSS selectors you can use to target the different elements.</p>
			</div>
		</div>

		<div>
			<h3>Looking for support?</h3>
        	<p>Having trouble? Please use the <a href="http://wordpress.org/support/plugin/mailchimp-for-wp">support forums</a> on WordPress.org.</p>
		</div>

	</div>

	

</div>