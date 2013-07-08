<div id="mc4wp-tab-checkbox-settings" class="mc4wp-tab <?php if($tab == 'checkbox-settings') { echo 'active'; } ?>">
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

</div>