<div id="mc4wp_admin" class="wrap">
	<h1>Configuration</h1>

	<form method="post" action="options.php">
		<?php settings_fields( 'mc4wp_options_group' ); ?>

		<h2>API Settings <?php if($connected) { ?><span class="status connected">CONNECTED</span> <?php } else { ?><span class="status not_connected">NOT CONNECTED</span><?php } ?></h2>
		<table class="form-table">

			<tr valign="top">
			    <th scope="row"><label for="mailchimp_api_key">MailChimp API Key</label> <a target="_blank" href="http://admin.mailchimp.com/account/api">(?)</a></th>
			    <td><input type="text" size="50" placeholder="Your MailChimp API key" id="mailchimp_api_key" name="mc4wp[mailchimp_api_key]" value="<?php echo $opts['mailchimp_api_key']; ?>" /></td>
			</tr>

		</table>

		<hr />
	    

	    <h2>MailChimp settings</h2>
	    <?php if($connected) { ?>

	    	<?php if(empty($opts['mailchimp_lists'])) { ?>
	    		<p class="alert warning"><b>Notice:</b> You must select atleast 1 list to which commenters should be subscribed.</p>
	    	<?php } ?>

		    <table class="form-table">
				<tr valign="top">
					<th scope="row">Lists</th>
					<td>
						<?php // loop through lists
				    	foreach($lists['data'] as $l) {
				    		?><input type="checkbox" id="list_<?php echo $l['id']; ?>_cb" name="mc4wp[mailchimp_lists][<?php echo $l['id']; ?>]" value="<?php echo $l['id']; ?>" <?php if(array_key_exists($l['id'], $opts['mailchimp_lists'])) echo 'checked="checked"'; ?>> <label for="list_<?php echo $l['id']; ?>_cb"><?php echo $l['name']; ?></label><br /><?php
				    	} ?>
					</td>
					<td class="desc">Select the lists to which your commenters should be subscribed</td>
				</tr>
				<tr valign="top">
					<th scope="row">Double opt-in?</th>
					<td><input type="radio" id="mc4wp_double_optin_1" name="mc4wp[mailchimp_double_optin]" value="1" <?php if($opts['mailchimp_double_optin'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_double_optin_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_double_optin_0" name="mc4wp[mailchimp_double_optin]" value="0" <?php if($opts['mailchimp_double_optin'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_double_optin_0">No</label></td>
					<td class="desc"></td>
				</tr>

			</table>


	    <?php } else { ?>
			<p>Please provide a valid API key first.</p>
		<?php } // end if connected ?>

		<hr />

		<h2>Checkbox Settings</h2>		
		<table class="form-table">
			<tr valign="top">
				<th scope="row">Add the checkbox to these forms</th>
				<td colspan="2">
					<label><input name="mc4wp[checkbox_show_at_comment_form]" value="1" type="checkbox" <?php if($opts['checkbox_show_at_comment_form']) echo 'checked '; ?>> Comment form</label> &nbsp; 
					<label><input name="mc4wp[checkbox_show_at_registration_form]" value="1" type="checkbox" <?php if($opts['checkbox_show_at_registration_form']) echo 'checked '; ?>> Registration form</label> &nbsp; 
					<?php if(is_multisite()) { ?><label><input name="mc4wp[checkbox_show_at_ms_form]" value="1" type="checkbox" <?php if($opts['checkbox_show_at_ms_form']) echo 'checked '; ?>> Multisite form</label> &nbsp; <?php } ?>
					<?php if($runs_buddypress) { ?><label><input name="mc4wp[checkbox_show_at_bp_form]" value="1" type="checkbox" <?php if($opts['checkbox_show_at_bp_form']) echo 'checked '; ?>> BuddyPress form</label> &nbsp; <?php } ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mc4wp_checkbox_label">Checkbox label text</label></th>
				<td colspan="2"><input type="text" size="50" id="mc4wp_checkbox_label" name="mc4wp[checkbox_label]" value="<?php echo $opts['checkbox_label']; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row">Pre-check the checkbox?</th>
				<td><input type="radio" id="mc4wp_checkbox_precheck_1" name="mc4wp[checkbox_precheck]" value="1" <?php if($opts['checkbox_precheck'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_checkbox_precheck_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_checkbox_precheck_0" name="mc4wp[checkbox_precheck]" value="0" <?php if($opts['checkbox_precheck'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_checkbox_precheck_0">No</label></td>
				<td class="desc"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Load some default CSS?</th>
				<td><input type="radio" id="mc4wp_checbox_css_1" name="mc4wp[checkbox_css]" value="1" <?php if($opts['checkbox_css'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_checbox_css_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_checbox_css_0" name="mc4wp[checkbox_css]" value="0" <?php if($opts['checkbox_css'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_checbox_css_0">No</label></td>
				<td class="desc">Tick "yes" if the checkbox appears in a weird place.</td>
			</tr>
			<tr valign="top">
				<td colspan="3"><p>Custom or additional styling can be applied by styling the paragraph element with ID <b>#mc4wp-checkbox</b> or it's child elements.</p></td>
			</tr>
		</table>
	    
	    <p class="submit">
	    	<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	    </p>

	</form>
</div>