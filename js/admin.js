(function($) { 

	// variables
	var FieldWizard;
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

	FieldWizard = {
		fields: {
			$value: $("#mc4wp_ffd_field_value"),
			$placeholder: $("#mc4wp_ffd_field_placeholder"),
			$type: $("#mc4wp_ffd_field_type"),
			$name: $("#mc4wp_ffd_field_name"),
			$all: $("#mc4wp_ffd_fields"),
			$wrapInP: $("#mc4wp_ffd_wrap_in_p"),
			$preview: $("#mc4wp_ffd_preview_field_code"),
			$form: $("#mc4wp_form_markup"),
			$required: $("#mc4wp_ffd_field_required"),
			$label: $("#mc4wp_ffd_field_label"),
			$preset: $("#mc4wp_ffd_field_preset"),
			$valueLabel: $("#mc4wp_ffd_field_value_label"),
			$grouping: $("#mc4wp_ffd_field_grouping")
		},
		getMarkup: function(what) {
			var markup = '', f = this.fields;

			var fieldId = "f%N%_"+ f.$name.val().toLowerCase().replace(/[^\w-]+/g,'');


			if(f.$type.val() == 'checkbox' || f.$type.val() == 'radio') {
				fieldId = fieldId.replace('groupings','') + '_' + f.$value.val().toLowerCase().replace(/[^\w-]+/g,'');
			}

			switch(what) {
				case 'input':
					markup += "<input type=\""+ f.$type.val() + "\" ";

					// add name attribute
					if(f.$type.val() != "submit") {
						markup += "name=\""+ f.$name.val() +"\" ";
					}

					// add value attribute
					if(f.$value.val() != '') { markup += "value=\""+ f.$value.val() +"\" "; }

					// add id attribute
					if(f.$type.val() != 'hidden' && f.$type.val() != 'submit') {
						markup += "id=\"" + fieldId + "\" ";
					}

					// if placeholder is given, add it. Otherwise, omit it for W3C validity
					if(f.$placeholder.is(':visible') && f.$placeholder.val() != '') { markup += "placeholder=\""+ f.$placeholder.val() +"\" "; }
					if(f.$required.is(':visible') && f.$required.is(":checked")) { markup += "required" ; }
					
					// add closing trailing flash
					markup += "/>";
				break;
				case 'label':
					// setup field code
					if(f.$label.is(':visible') && f.$label.val() != '') { markup += "<label for=\"" + fieldId +"\">"+ f.$label.val() +"</label>\n\t"; }

				break;
			}

			return markup;
		},
		updatePreviewCode: function() {
			var f = this.fields, fieldPreview = '';

			// wrap in <p> tags if necessary
			if(f.$wrapInP.is(':checked:visible')) { fieldPreview += "<p>\n\t"; }

			if(f.$type.val() == 'checkbox' || f.$type.val() == 'radio') {
				// reverse label and input field order
				fieldPreview += this.getMarkup('input');
				fieldPreview += this.getMarkup('label');
			} else {
				fieldPreview += this.getMarkup('label');
				fieldPreview += this.getMarkup('input');
			}

			// add closing </p> tag, if necessary
			if(f.$wrapInP.is(':checked:visible')) { fieldPreview += "\n</p>"; }

			// show preview code
			f.$preview.val(fieldPreview);
		},
		setup: function(fieldType) {
			var f = this.fields;
			// reset
			f.$all.hide();
			f.$all.find('p.row').show();
			f.$all.find('p.row-grouping-id').hide();

		
			// set field defaults
			f.$name.val('');
			f.$value.val('');
			f.$label.val('');
			f.$placeholder.val('');
			f.$preset.val('');
			f.$grouping.val('');
			f.$wrapInP.attr('checked', true);
			f.$required.attr('checked', false);
			f.$valueLabel.html("Initial value <small>(optional)</small>");
			f.$preset.find('option[value="group"]').attr('disabled', 'disabled');

			// hide or show some of the fields, depending on chosen fieldType
			switch(fieldType) {

				case 'hidden':
					f.$all.find('.row-placeholder, .row-wrap-in-p, .row-label, .row-required').hide();
					f.$wrapInP.attr('checked', false);
					f.$preset.find('option[value="group"]').removeAttr('disabled');
				break;

				case 'submit':
					f.$all.find('.row-placeholder, .row-name, .row-label, .row-required, .row-preset').hide();
					f.$valueLabel.html("Button text");
				break;

				case 'checkbox':
				case 'radio':
					f.$all.find('.row-placeholder, .row-required').hide();
					f.$valueLabel.html("Value");
					f.$preset.find('option[value="group"]').removeAttr('disabled');
				break;

			}

			f.$all.show();
			FieldWizard.preset(f.$preset.val());
			FieldWizard.updatePreviewCode();
		},
		validateFields: function() {
			var f = this.fields, arrayCharPos, name;

			name = f.$name.val().trim();
			arrayCharPos = name.indexOf('[');

			if(arrayCharPos !== -1) {
				name = name.substring(0, arrayCharPos).toUpperCase().replace(/\s+/g,'') + name.substring(arrayCharPos);
			} else {
				name = name.toUpperCase();
			}

			f.$name.val(name);
		},
		preset: function(preset) {
			var f = this.fields;

			switch(preset) {
				case '': 
					return false; 
				break;
				case 'email':
					f.$label.val("Email address");
					f.$name.val('EMAIL');
					f.$placeholder.val("Your email address");
					f.$required.attr('checked', true);
				break;
				case 'fname':
					f.$label.val('First name:');
					f.$name.val('FNAME');
					f.$placeholder.val("Your first name");
				break;
				case 'lname':
					f.$label.val('Last name:');
					f.$name.val('LNAME');
					f.$placeholder.val("Your last name");
				break;
				case 'name':
					f.$label.val('Name:');
					f.$name.val('NAME');
					f.$placeholder.val("Your name");
				break;
				case 'group':
					f.$all.find('p.row-grouping-id').show();
					f.$all.find('p.row-name').hide();

					if(f.$type.val() == 'checkbox' || f.$type.val() == 'radio') {
						f.$valueLabel.html("Group name");
					} else {
						f.$valueLabel.html("Group names <small>(separated by comma)</small>");
					}
				break;

			}
		},
		transferCodeToForm: function() {
			var f = this.fields;
			f.$form.val(f.$form.val() + "\n" + f.$preview.val());
		},
		validateSettings: function() {
			var html;

			html = this.fields.$form.val();

			// simple check to see if form mark-up contains the proper e-mail field
			if(html.indexOf('="EMAIL"') == -1) {
				return confirm('It seems that your form does not contain an input field for the email address.' + "\n\n"
					+ 'Please make sure your form contains an input field with a name="EMAIL" attribute.' + "\n\n"
					+ 'Example: <input type="text" name="EMAIL"....' + "\n\n"
					+ 'Click OK to save settings nonetheless or cancel to go back and edit the form mark-up.');
			}

			return true;
		},
		setNameAttributeForGrouping: function() {
			f = this.fields;
			if(f.$type.val() == 'checkbox') {
				f.$name.val('GROUPINGS[' + f.$grouping.val() +'][]');
			} else {
				f.$name.val('GROUPINGS[' + f.$grouping.val() +']');				
			}
		}
	}

	// Events
	$("#mc4wp_ffd_field_type").change(function() {
		FieldWizard.setup($(this).val());		
	});
	$("#mc4wp_ffd_field_preset").change(function() {
		FieldWizard.preset($(this).val());
	});

	$("#mc4wp_ffd_fields :input").change(function() {
		FieldWizard.validateFields();
		FieldWizard.updatePreviewCode();
	});
	$("#mc4wp_ffd_add_to_form").click(function(e) { 
		FieldWizard.transferCodeToForm();
		return false;
	});
	$("#mc4wp_ffd_field_grouping").change(function() {
		FieldWizard.setNameAttributeForGrouping();
		FieldWizard.updatePreviewCode()
	});
	$("#mc4wp-submit-form-settings").click(function(e) {
		return FieldWizard.validateSettings();
	});


})(jQuery);

