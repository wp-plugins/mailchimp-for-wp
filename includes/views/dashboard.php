<div id="mc4wp_admin" class="wrap">

	<h1>MailChimp for WordPress - Configuration</h1>

	<ul id="mc4wp-nav">
		<li><a <?php if($tab == 'api-settings') echo 'class="active"'; ?> href="#api-settings">API settings</a></li>
		<li><a <?php if($tab == 'mailchimp-settings') echo 'class="active"'; ?> href="#mailchimp-settings">MailChimp settings</a></li>
		<li><a <?php if($tab == 'checkbox-settings') echo 'class="active"'; ?> href="#checkbox-settings">Checkbox settings</a></li>
		<li><a <?php if($tab == 'form-settings') echo 'class="active"'; ?> href="#form-settings">Form settings</a></li>
	</ul>

	<h2 style="display:none;"></h2>
	<?php settings_errors(); ?>

	<div style="float:left; width:70%;">

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

		<p class="copyright-notice">I would like to remind you that this plugin is <b>not</b> developed by or affiliated with MailChimp in any way. My name is <a href="http://www.dannyvankooten.com/">Danny van Kooten</a>, I am a Dutch freelance webdeveloper thinking you might like a plugin like this. :-)</p>

	</div>

	<div style="width:26%; float:right; margin-left:3%;">
		
		<div class="box donatebox">
			<h3>Donate $10, $20 or $50</h3>
			<p>I spent countless hours developing this plugin for <b>FREE</b>. If you like it, consider donating a small token of your appreciation. It is much appreciated!</p>
					
			<form class="donate" action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<input type="hidden" name="cmd" value="_donations">
				<input type="hidden" name="business" value="AP87UHXWPNBBU">
				<input type="hidden" name="lc" value="US">
				<input type="hidden" name="item_name" value="Danny van Kooten">
				<input type="hidden" name="item_number" value="MailChimp for WordPress">
				<input type="hidden" name="currency_code" value="USD">
				<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<img alt="" border="0" src="https://www.paypalobjects.com/nl_NL/i/scr/pixel.gif" width="1" height="1">
			</form>

			<p>Or you can: </p>
            <ul>
                <li><a href="http://wordpress.org/extend/plugins/mailchimp-for-wp/">Give a 5&#9733; review on WordPress.org</a></li>
                <li><a href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Blog about it and link to the plugin page</a></li>
                <li style="vertical-align:bottom;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/" data-text="Showing my appreciation to @DannyvanKooten for his #WordPress plugin: MailChimp for WP" data-count="none">Tweet</a></li>
            </ul>
        </div>

        <?php if($tab == 'form-settings') { ?>
		<div>
			<h4>Notes regarding the form designer</h4>
			<p>As a minimum, your form should include an email address field and a submit button field.</p>
			<p>Add other fields if you like but make sure to match your MailChimp list requirements. 
			All additional fields will be sent to MailChimp with the sign-up request. Data will be named like the 'name' attribute you've given to your fields.</p>
			<p><b>For example:</b> suppose your list uses <em>FNAME</em> to collect first names of your list subscribers.
				In this case you should create a text field with 'fname' as it's name attribute. Name attributes are case-insensitive.</p>
			<h4>Special form strings</h4>
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

			<p>Style the output of the form by applying CSS rules to <b>form.mc4wp-form</b> and its child elements. Add these CSS rules to your theme's stylesheet
				 which can in most cases be found here: <em><?php echo get_stylesheet_directory(); ?>/style.css</em>.</p>
		</div>
		<?php } ?>

		<div>
			<h3>Looking for support?</h3>
			<p>Please post your questions, bug reports or feature requests regarding MailChimp for WP in the <a href="http://wordpress.org/support/plugin/mailchimp-for-wp">WordPress support forums</a> so others might be able to benefit from this too. I will try to respond as soon as I possibly can.</p>
		</div>

	</div>

	

</div>