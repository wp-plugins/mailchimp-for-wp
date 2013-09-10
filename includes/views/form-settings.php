<div id="mc4wp-tab-form-settings" class="mc4wp-tab <?php if($tab == 'form-settings') { echo 'active'; } ?>">
		
	<h2>Form Settings</h2>		
	
	<p>MailChimp for WP comes packed with a neat shortcode you can use in your posts, pages or text widgets to display a sign-up form. 
		Configure the form below, then paste <input size="10" type="text" onfocus="this.select();" readonly="readonly" value="[mc4wp-form]" class="mc4wp-shortcode-example"> in a post, page or text widget and watch your list(s) grow!</p>

	<?php if($opts['form_usage'] && empty($opts['form_lists'])) { ?>
	<p class="alert warning"><b>Notice:</b> You must select atleast 1 list to subscribe to.</p>
	<?php } ?>

	<table class="form-table">
		<tbody>
			<tr valign="top">
				<th scope="row">Use form functionality?</th>
				<td><input type="radio" id="mc4wp_form_usage_1" name="mc4wp_lite[form_usage]" value="1" <?php if($opts['form_usage'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_usage_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_form_usage_0" name="mc4wp_lite[form_usage]" value="0" <?php if($opts['form_usage'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_usage_0">No</label></td>
				<td class="desc">Tick "yes" if you want to be able to use the <i>[mc4wp-form]</i> shortcode.</td>
			</tr>
		</tbody>
		<tbody id="mc4wp_form_options" <?php if(!$opts['form_usage']) { ?>style="display:none;"<?php } ?>>
			<tr valign="top">
				<th scope="row">Lists</th>
					<?php // loop through lists
					if(!$connected) { 
						?><td colspan="2">Please connect to MailChimp first.</td><?php
					} else { ?>
					<td>
						<?php foreach($lists as $l) { if(!is_array($l)) { continue; }
							?><input type="checkbox" id="mc4wp_form_list_<?php echo $l['id']; ?>_cb" name="mc4wp_lite[form_lists][<?php echo $l['id']; ?>]" value="<?php echo $l['id']; ?>" <?php if(array_key_exists($l['id'], $opts['form_lists'])) echo 'checked="checked"'; ?>> <label for="mc4wp_form_list_<?php echo $l['id']; ?>_cb"><?php echo $l['name']; ?></label><br /><?php
						} ?>
					</td>
					<td class="desc">Select MailChimp lists for this form</td>
					<?php
				} ?>
				
			</tr>
			<tr valign="top">
				<th scope="row">Enable AJAX?</th>
				<td><a href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Upgrade to Pro to use AJAX forms</a></td>
				<td class="desc">Submit forms with AJAX, meaning the page doesn't have to reload.</td>
			</tr>
			<tr valign="top">
				<th scope="row">Double opt-in?</th>
				<td><input type="radio" id="mc4wp_form_double_optin_1" name="mc4wp_lite[form_double_optin]" value="1" <?php if($opts['form_double_optin'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_double_optin_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_form_double_optin_0" name="mc4wp_lite[form_double_optin]" value="0" <?php if($opts['form_double_optin'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_double_optin_0">No</label></td>
				<td class="desc"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Load some default CSS?</th>
				<td><input type="radio" id="mc4wp_form_css_1" name="mc4wp_lite[form_css]" value="1" <?php if($opts['form_css'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_css_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_form_css_0" name="mc4wp_lite[form_css]" value="0" <?php if($opts['form_css'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_css_0">No</label></td>
				<td class="desc">Tick "yes" for basic form formatting.</td>
			</tr>
			<tr valign="top">
				<th scope="row" colspan="3" style="font-weight:bold;">Form mark-up</th>
			</tr>
			<tr valign="top">
				<td colspan="3">

					<div class="mc4wp-wrapper">

						<div class="mc4wp-col mc4wp-col-2-3 mc4wp-first">
							<?php 
							if(function_exists('wp_editor')) {
								wp_editor( $opts['form_markup'], 'mc4wpformmarkup', array('tinymce' => false, 'media_buttons' => false, 'textarea_name' => 'mc4wp_lite[form_markup]'));
							} else {
								?><textarea class="widefat" cols="160" rows="20" id="mc4wpformmarkup" name="mc4wp_lite[form_markup]"><?php echo esc_textarea($opts['form_markup']); ?></textarea><?php
							} ?>
							<p><small>Use <input type="text" onfocus="this.select();" readonly="readonly" value="[mc4wp-form]" size="10" class="mc4wp-shortcode-example"> to render this form inside a widget, post or page. </small></p>
							<p class="submit">
								<input type="submit" class="button-primary" value="<?php _e('Save All Changes') ?>" id="mc4wp-submit-form-settings" />
	</p>					</p>
						</div>

						<div class="mc4wp-col mc4wp-col-1-3 mc4wp-last">
							<?php include('parts/field-wizard.php'); ?>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>

	<div id="mc4wp_form_options_2" <?php if(!$opts['form_usage']) { ?>style="display:none;"<?php } ?>>
		<h3>Visual feedback to subscriber</h3>
		<table class="form-table mc4wp-form-messages">
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_hide_after_success">Hide form after a successful sign-up?</label></th>
				<td><input type="radio" id="mc4wp_form_hide_after_success_1" name="mc4wp_lite[form_hide_after_success]" value="1" <?php if($opts['form_hide_after_success'] == 1) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_hide_after_success_1">Yes</label> &nbsp; <input type="radio" id="mc4wp_form_hide_after_success_0" name="mc4wp_lite[form_hide_after_success]" value="0" <?php if($opts['form_hide_after_success'] == 0) echo 'checked="checked"'; ?> /> <label for="mc4wp_form_hide_after_success_0">No</label></td>
				<td class="desc">Tick "yes" to only show the success message after a successful sign-up.</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mc4wp_form_redirect">Redirect to this URL after a successful sign-up</label></th>
				<td colspan="2">
					<input type="text" class="widefat" name="mc4wp_lite[form_redirect]" id="mc4wp_form_redirect" value="<?php echo $opts['form_redirect']; ?>" />
					<small>Leave empty or enter <strong>0</strong> (zero) for no redirection.</small>
				</td>
			</tr>
				<tr valign="top">
					<th scope="row"><label for="mc4wp_form_text_success">Success message</label></th>
					<td colspan="2" ><input type="text" class="widefat" id="mc4wp_form_text_success" name="mc4wp_lite[form_text_success]" value="<?php echo esc_attr($opts['form_text_success']); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="mc4wp_form_text_error">General error message</label></th>
					<td colspan="2" ><input type="text" class="widefat" id="mc4wp_form_text_error" name="mc4wp_lite[form_text_error]" value="<?php echo esc_attr($opts['form_text_error']); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="mc4wp_form_text_invalid_email">Invalid email address message</label></th>
					<td colspan="2" ><input type="text" class="widefat" id="mc4wp_form_text_invalid_email" name="mc4wp_lite[form_text_invalid_email]" value="<?php echo esc_attr($opts['form_text_invalid_email']); ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="mc4wp_form_text_already_subscribed">Email address is already on list message</label></th>
					<td colspan="2" ><input type="text" class="widefat" id="mc4wp_form_text_already_subscribed" name="mc4wp_lite[form_text_already_subscribed]" value="<?php echo esc_attr($opts['form_text_already_subscribed']); ?>" /></td>
				</tr>
				<tr>
					<th></th>
					<td colspan="2"><p><small>HTML tags like &lt;a&gt; and &lt;strong&gt; etc. are allowed in the message fields.</small></p></td>
				</tr>
			</table>

		</div>

		<?php submit_button("Save All Changes"); ?>

	</div>