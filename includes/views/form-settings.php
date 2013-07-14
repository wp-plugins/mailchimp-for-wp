<div id="mc4wp-tab-form-settings" class="mc4wp-tab <?php if($tab == 'form-settings') { echo 'active'; } ?>">
	<h2>Form Settings</h2>		
	
	<p>MailChimp for WP comes packed with a neat shortcode you can use in your posts, pages or text widgets to display a sign-up form. Configure the form below, then paste <i>[mc4wp-form]</i> in a post, page or text widget and watch your list(s) grow!</p>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row">Use form functionality?</th>
				<td><input type="radio" id="mc4wp_form_usage_1" name="mc4wp[form_usage]" value="1" <?php if($opts['form_usage'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_usage_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_form_usage_0" name="mc4wp[form_usage]" value="0" <?php if($opts['form_usage'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_usage_0">No</label></td>
				<td class="desc">Tick "yes" if you want to be able to use the <i>[mc4wp-form]</i> shortcode.</td>
			</tr>
		</tbody>
		<tbody id="mc4wp_form_options" <?php if(!$opts['form_usage']) { ?>style="display:none;"<?php } ?>>
			<tr valign="top">
				<th scope="row">Load some default CSS?</th>
				<td><input type="radio" id="mc4wp_form_css_1" name="mc4wp[form_css]" value="1" <?php if($opts['form_css'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_css_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_form_css_0" name="mc4wp[form_css]" value="0" <?php if($opts['form_css'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_css_0">No</label></td>
				<td class="desc">Tick "yes" for basic form formatting.</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_redirect">Redirect to this URL after sign-up</label> <small>(leave empty if you don't want to redirect)</small></th>
				<td><input colspan="2" type="text" size="50" name="mc4wp[form_redirect]" id="mc4wp_form_redirect" value="<?php echo $opts['form_redirect']; ?>" />
			</tr>
			<tr valign="top">
				<th scope="row" colspan="3">Form mark-up</th>
			</tr>
			<tr valign="top">
				<td colspan="2">
					<textarea cols="160" rows="20" id="mc4wp_form_markup" name="mc4wp[form_markup]"><?php echo $opts['form_markup']; ?></textarea>
				</td>
				<td>
					<form id="mc4wp_ffd">

						<p>
							<select id="mc4wp_ffd_add_field">
								<option>Add field or button..</option>
								<option value="name">Full name</option>
								<option value="fname">First name</option>
								<option value="lname">Last name</option>
								<option value="email">Email address</option>
								<option value="text">Text field</option>
								<option value="hidden">Hidden field</option>
								<option value="submit">Submit button</option>
							</select>
						</p>
						<div id="mc4wp_ffd_fields">

							<p class="row-type">
								<label for="mc4wp_ffd_field_type">Type</label>
								
								<select id="mc4wp_ffd_field_type">
									<option value="text">text</option>
									<option value="email">email (HTML5)</option>
									<option value="hidden">hidden</option>
									<option value="submit">submit</option>
								</select>
							</p>

							<p class="row-name">
								<label for="mc4wp_ffd_field_name">Name</label>
								<input type="text" id="mc4wp_ffd_field_name" />
							</p>

							<p class="row-value">
								<label for="mc4wp_ffd_field_value">Initial value</label>
								<input type="text" id="mc4wp_ffd_field_value" />
							</p>

							<p class="row-placeholder">
								<label for="mc4wp_ffd_field_placeholder">Placeholder</label>
								<input type="text" id="mc4wp_ffd_field_placeholder" />
								<small>(HTML 5)</small>
							</p>

							<p class="row-label">
								<label for="mc4wp_ffd_field_label">Label</label>
								<input type="text" id="mc4wp_ffd_field_label" />
							</p>

							<p class="row-wrap-in-p"><input type="checkbox" id="mc4wp_ffd_wrap_in_p" value="1" checked /> <label for="mc4wp_ffd_wrap_in_p">Wrap in paragraph (p) tags?</label></p>
							
							<p class="row-required"><input type="checkbox" id="mc4wp_ffd_field_required" value="1" /> <label for="mc4wp_ffd_field_required">Required field?</label></p>

							<textarea style="width:100%;" cols="60" rows="5" id="mc4wp_ffd_preview_field_code"></textarea>

							<input type="button" id="mc4wp_ffd_add_to_form" value="&laquo; add to form" />
						</form>
					</div>
				</td>
			</tr>
		</tbody>
	</table>

	<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

	<div id="mc4wp_form_options_2" <?php if(!$opts['form_usage']) { ?>style="display:none;"<?php } ?>>
		<h3>Form messages</h3>
		<table class="form-table mc4wp-form-messages">
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_text_success">Success message</label></th>
				<td><input type="text" size="100" id="mc4wp_form_text_success" name="mc4wp[form_text_success]" value="<?php echo $opts['form_text_success']; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_text_error">General error message</label></th>
				<td><input type="text" size="100" id="mc4wp_form_text_error" name="mc4wp[form_text_error]" value="<?php echo $opts['form_text_error']; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_text_invalid_email">Invalid email address message</label></th>
				<td><input type="text" size="100" id="mc4wp_form_text_invalid_email" name="mc4wp[form_text_invalid_email]" value="<?php echo $opts['form_text_invalid_email']; ?>" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_text_already_subscribed">Email address is already on list message</label></th>
				<td><input type="text" size="100" id="mc4wp_form_text_already_subscribed" name="mc4wp[form_text_already_subscribed]" value="<?php echo $opts['form_text_already_subscribed']; ?>" /></td>
			</tr>
		</table>

		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</div>

</div>