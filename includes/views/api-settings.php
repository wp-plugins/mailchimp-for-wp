<div id="mc4wp-tab-api-settings" class="mc4wp-tab <?php if($tab == 'api-settings') { echo 'active'; } ?>">

	<h2>API Settings <?php if($connected) { ?><span class="status connected">CONNECTED</span> <?php } else { ?><span class="status not_connected">NOT CONNECTED</span><?php } ?></h2>
	<table class="form-table">

		<tr valign="top">
			<th scope="row"><label for="mailchimp_api_key">MailChimp API Key</label> <a target="_blank" href="http://admin.mailchimp.com/account/api">(?)</a></th>
			<td><input type="text" size="50" placeholder="Your MailChimp API key" id="mailchimp_api_key" name="mc4wp[mailchimp_api_key]" value="<?php echo $opts['mailchimp_api_key']; ?>" /></td>
		</tr>

	</table>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

</div>