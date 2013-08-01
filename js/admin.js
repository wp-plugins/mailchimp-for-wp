(function($) { 

	// variables
	var FormDesigner;
	// event bindings
	$("#mc4wp-nav a").click(function(e) {
		var target, wp_referer;

		target = $(this).attr('data-target');
		$("#mc4wp-tabs .mc4wp-tab.active").removeClass('active');
		$("#mc4wp-tab-" + target).addClass('active');

		// show info tabs
		$("#mc4wp-info-tabs .info-tab").hide();
		$("#mc4wp-info-tabs .info-tab-" + target).show();

		$("#mc4wp-nav .active").removeClass('active');
		$(this).addClass('active');

		// Change window location to add URL params
		if (window.history && history.replaceState) {
		  // NOTE: doesn't take into account existing params
			history.replaceState("", "", $(this).attr('href'));
		}

		// update WP hidden input field
		$('input[name="_wp_http_referer"]').val(mc4wp_urls.admin_page + "&tab=" + target);

		if($("#mc4wp-tab-" + target).is(":visible")) {
			e.preventDefault();
			return false;
		} else {
			return true;
		}
		
	});

	$("#mc4wp_form_usage_1").click(function() { 
		$("#mc4wp_form_options, #mc4wp_form_options_2").fadeIn(); 
	});
	$("#mc4wp_form_usage_0").click(function() { 
		$("#mc4wp_form_options, #mc4wp_form_options_2").fadeOut(); 
	});

	FormDesigner = {
		fields: {
			$value: $("#mc4wp_ffd_field_value"),
			$placeholder: $("#mc4wp_ffd_field_placeholder"),
			$type: $("#mc4wp_ffd_field_type"),
			$name: $("#mc4wp_ffd_field_name"),
			$all: $("#mc4wp_ffd_fields"),
			$wrap: $("#mc4wp_ffd_wrap_in_p"),
			$preview: $("#mc4wp_ffd_preview_field_code"),
			$form: $("#mc4wp_form_markup"),
			$required: $("#mc4wp_ffd_field_required"),
			$label: $("#mc4wp_ffd_field_label")
		},
		updatePreviewCode: function() {
			var f = this.fields, fieldPreview = '';

			// wrap in <p> tags if necessary
			if(f.$wrap.is(':checked')) { fieldPreview += "<p>\n\t"; }

			// setup field code
			if(f.$label.val() != '') { fieldPreview += "<label for=\"mc4wp_f%N%_"+ f.$name.val() +"\">"+ f.$label.val() +"</label>"; }

			fieldPreview += "<input type=\""+ f.$type.val() + "\" name=\""+ f.$name.val() +"\" value=\""+ f.$value.val() +"\" ";

			// if placeholder is given, add it. Otherwise, omit it for W3C validity
			if(f.$placeholder.val() != '') { fieldPreview += "placeholder=\""+ f.$placeholder.val() +"\" "; }
			if(f.$required.is(":checked")) { fieldPreview += "required" ; }
			
			// add closing trailing flash
			fieldPreview += "/>";

			// add closing </p> tag, if necessary
			if(f.$wrap.is(':checked')) { fieldPreview += "\n</p>"; }

			// show preview code
			f.$preview.val(fieldPreview);
		},
		setupFieldDesigner: function(preset) {
			var f = this.fields;
			// reset
			f.$all.hide();
			f.$all.find('p').show();
		
			// set field defaults
			f.$type.val("text");
			f.$name.val('');
			f.$value.val('');
			f.$label.val('');
			f.$placeholder.val('');
			f.$wrap.prop('checked', true);
			f.$required.prop('checked', false);

			// help by setting some defaults
			switch(preset) {

				case '': 
					return false; 
				break;

				case 'hidden':
					f.$type.val("hidden");
					f.$all.find('.row-placeholder, .row-wrap-in-p, .row-label, .row-required').hide();
					f.$wrap.prop('checked', false);
				break;

				case 'submit':
					f.$type.val("submit");
					f.$all.find('.row-placeholder, .row-name, .row-label, .row-required').hide();
				break;

				case 'fname':
					f.$label.val('First name:');
					f.$name.val('fname');
					f.$placeholder.val("Your first name");
				break;

				case 'lname':
					f.$label.val('Last name:');
					f.$name.val('lname');
					f.$placeholder.val("Your last name");
				break;

				case 'name':
					f.$label.val('Name:');
					f.$name.val('name');
					f.$placeholder.val("Your name");
				break;

				case 'email':
					f.$label.val("Email address");
					f.$name.val('email');
					f.$type.val('email');
					f.$placeholder.val("Your email address");
					f.$required.prop('checked', true);
				break;

			}

			f.$all.show();
			FormDesigner.updatePreviewCode();
		},
		transferCodeToForm: function() {
			var f = this.fields;
			f.$form.val(f.$form.val() + "\n" + f.$preview.val());
		},
		validateSettings: function() {
			var html;

			html = this.fields.$form.val();

			// simple check to see if form mark-up contains the proper e-mail field
			if(html.toLowerCase().indexOf('name="email"') == -1) {
				return confirm('It seems that your form does not contain an input field for the email address.' + "\n\n"
					+ 'Please make sure your form contains an input field with a name="email" attribute.' + "\n\n"
					+ 'Example: <input type="text" name="email"....' + "\n\n"
					+ 'Click OK to save settings nonetheless or cancel to go back and edit the form mark-up.');
			}

			return true;
		}
	}

	// Events
	$("#mc4wp_ffd_add_field").change(function() {
		FormDesigner.setupFieldDesigner($(this).val());		
	});

	$("#mc4wp_ffd_fields :input").change(function() {
		FormDesigner.updatePreviewCode();
	});
	$("#mc4wp_ffd_add_to_form").click(function(e) { 
		FormDesigner.transferCodeToForm();
		return false;
	});
	$("#mc4wp-submit-form-settings").click(function(e) {
		return FormDesigner.validateSettings();
	});

	FormDesigner.fields.$form.bind('copy', function(e) {
		return alert("Use the [mc4wp-form] shortcode to render this form inside a page, post or widget.");
	});



})(jQuery);

