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
			$container: $("#mc4wp-fw .mc4wp-fields"),
			$fields: $("#mc4wp-fw .mc4wp-fields :input"),
			$fieldRows: $("#mc4wp-fw .field-row"),
			$textFields: $("#mc4wp-fw .mc4wp-fields :input[type='text']"),
			$form: $("#mc4wpformmarkup"),
			$grouping: $("#mc4wp-fw-grouping"),
			$label: $("#mc4wp-fw-label"),
			$name: $("#mc4wp-fw-name"),
			$value: $("#mc4wp-fw-value"),
			$placeholder: $("#mc4wp-fw-placeholder"),
			$type: $("#mc4wp-fw-type"),
			$wrapInP: $("#mc4wp-fw-p"),
			$preview: $("#mc4wp-fw-preview"),
			$required: $("#mc4wp-fw-req"),
			$preset: $("#mc4wp-fw-preset"),
			$valueLabel: $("#mc4wp-fw-value-label")
		},
		init: function() {
			f = this.fields;

			// Events
			f.$type.change(this.setup);
			f.$type.change(this.preview);
			f.$preset.change(this.preset);
			f.$name.change(this.validate.nameField);
			f.$grouping.change(this.validate.nameField);
			f.$fields.change(this.preview);
			$("#mc4wp-fw-add-to-form").click(FieldWizard.publish);
			$("#mc4wp-submit-form-settings").click(this.validate.hasEmailField);
		},
		validate: {
			nameField: function() {
				var f = FieldWizard.fields, name, arrayCharPos;

				if(f.$preset.val() == 'group') {
					if(f.$type.val() == 'checkbox' || f.$type.val() == 'radio') {
						f.$name.val('GROUPINGS[' + f.$grouping.val() +'][]');
					} else {
						f.$name.val('GROUPINGS[' + f.$grouping.val() +']');				
					}
					return;
				}				
				

				name = f.$name.val().trim();
				if((arrayCharPos = name.indexOf('[')) != -1) {
					name = name.substring(0, arrayCharPos).toUpperCase().replace(/\s+/g,'') + name.substring(arrayCharPos);
				} else {
					name = name.toUpperCase().replace(/\s+/g,'');
				}
				
				f.$name.val(name);
				return true;
			},
			hasEmailField: function() {
				// simple check to see if form mark-up contains the proper e-mail field
				if(FieldWizard.fields.$form.val().indexOf('="EMAIL"') == -1) {
					return confirm('It seems that your form does not contain an input field for the email address.' + "\n\n"
						+ 'Please make sure your form contains an input field with a name="EMAIL" attribute.' + "\n\n"
						+ 'Example: <input type="text" name="EMAIL"....' + "\n\n"
						+ 'Click OK to save settings nonetheless or cancel to go back and edit the form mark-up.');
				}

				return true;
			}
		},
		publish: function() {
			var f = FieldWizard.fields, formMarkup;
			formMarkup = f.$form.val() + "\n" + f.$preview.val();
			f.$form.val(formMarkup);
		},
		preview: function() {

			var f = FieldWizard.fields, $p, $input, $label, fieldType, fieldId;

			fieldType = f.$type.val();

			$input = $("<input>");
			$input.attr('type', fieldType);

			if(fieldType != 'submit') { $input.attr('name', f.$name.val()); }

			if(f.$value.val().length > 0) $input.val(f.$value.val());

			if(f.$name.val().length > 0 && fieldType != 'submit' && fieldType != 'hidden') {
				// generate field id
				if(fieldType == 'checkbox' || fieldType == 'radio') {
					fieldId = "f%N%_" + f.$name.val().toLowerCase().replace(/[^\w-]+/g,'').replace('groupings','') + '_' + f.$value.val().toLowerCase().replace(/[^\w-]+/g,'');
				} else {
					fieldId = "f%N%_"+ f.$name.val().toLowerCase().replace(/[^\w-]+/g,'');
				}
								
				$input.attr('id', fieldId);
			}

			if(f.$placeholder.val() != '' && f.$placeholder.is(':visible')) {
				$input.attr('placeholder', f.$placeholder.val());
			}

			if(f.$required.is(":checked:visible")) {
				$input.attr('required', true);
			}

			$code = $input.wrap("<p />").parent();

			if(f.$wrapInP.is(":checked:visible")) {
				$p = $input.wrap("<p />").parent();
				$("<br>").insertBefore($input).clone().insertAfter($input);
			}

			if(f.$label.val() != '' && f.$label.is(':visible')) {
				$label = $("<label />");
				$label.attr('for', fieldId);
				$label.html(f.$label.val());

				if(fieldType == 'radio' || fieldType == 'checkbox') {
					$label.insertAfter($input);
					$("<br>").insertAfter($input);
				} else {
					$label.insertBefore($input);
					$("<br>").insertAfter($label);
				}
			}		

			f.$preview.val($code.html().replace(/<br>/gi, "\n"));

			return;
		},
		setup: function() {
			var f, fieldType, visibleRows;

			f = FieldWizard.fields;
			fieldType = f.$type.val();

			// reset
			f.$container.hide();
			f.$fieldRows.hide();
			f.$textFields.val('');
			f.$wrapInP.attr('checked', true);
			f.$required.attr('checked', false);
			f.$preset.val('').find('option').attr('disabled', true);
			f.$valueLabel.html("Initial value <small>(optional)</small>");

			if(fieldType == '') { return; }

			// show the container
			f.$container.show();

			visibleRows = {
				text: ['preset', 'name', 'label', 'value', 'req', 'p', 'placeholder'],
				hidden: ['preset', 'name', 'value'],
				email: ['preset', 'name', 'label', 'value', 'req', 'p', 'placeholder'],
				checkbox: ['preset', 'name', 'label', 'value', 'p'],
				radio: ['preset', 'name', 'label', 'value', 'p'],
				submit: ['value', 'p'],
				date: [ 'name', 'label', 'req', 'p'],
				tel: [ 'name', 'label', 'req', 'p', 'placeholder'],
				url: [ 'name', 'label', 'req', 'p', 'placeholder']
			}

			availablePresets = {
				text: ['name', 'fname', 'lname', 'email'],
				hidden: ['group'],
				email: ['email'],
				radio: ['group'],
				checkbox: ['group'],
				submit: [],

			}

			// show field rows for chosen fieldType
			for(var i = 0; i < visibleRows[fieldType].length; i++) {
				f.$container.children('.row-' + visibleRows[fieldType][i]).show();
			}

			numberOfAvailablePresets = availablePresets[fieldType].length;
			if(numberOfAvailablePresets == 0) {
				f.$container.find('.row-preset').hide();
			} else {
				for(var i = 0; i < numberOfAvailablePresets; i++) {
					f.$preset.find('option[value="'+ availablePresets[fieldType][i] +'"]').removeAttr('disabled');
				}
			} 

			// customize texts
			if(fieldType == 'submit') {
				f.$valueLabel.html('Button text');
			} else if(fieldType == 'checkbox' || fieldType == 'radio') {
				f.$valueLabel.html("Value");
			}

			return true;
		},
		preset: function() {
			var f = FieldWizard.fields, preset;
			preset = f.$preset.val();

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
					f.$container.find('.row-grouping').show();
					f.$container.find('.row-name').hide();

					if(f.$type.val() == 'checkbox' || f.$type.val() == 'radio') {
						f.$valueLabel.html("Group name");
					} else {
						f.$valueLabel.html("Group names <small>(separated by comma)</small>");
					}
				break;

			}
		}
	}

	FieldWizard.init();


})(jQuery);

