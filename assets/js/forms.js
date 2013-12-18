(function() {
	
	function populateFields(container, data, basename) {

		for(var key in data) {

			var name = key;
			var value = data[key];

			// no need to set empty values
			if(value == "") {
				continue;
			}

			// handle array name attributes
			if(typeof(basename) !== "undefined") {
				name = basename + "[" + key + "]";
			}

			if(value.constructor == Array) {
				name += '[]';
			} else if(typeof value == "object") {
				populateFields(container, value, name);
				continue;
			}

			// populate field
			var elements = container.querySelectorAll('input[name="'+ name +'"], select[name="'+ name +'"], textarea[name="'+ name +'"]');
			
			// Dirty: abandon if we did not find the element
			if(!elements) { 
				return; 
			}

			// loop through found elements to set their values
			for(var i = 0; i < elements.length; i++) {

				var element = elements[i];

				// check element type
				switch(element.type || element.tagName) {
					case 'text':
					case 'email':
					case 'date':
					case 'tel':
						element.value = value;
						element.className = element.className.replace('placeholdersjs','');
						break;

					case 'radio':
						element.checked = (element.value === value);
						break;

					case 'checkbox':
						for(var j = 0; j < value.length; j++) {
							element.checked = (element.value === value[j]);
						}
						break;

					case 'select-multiple':
						var values = value.constructor == Array ? value : [value];

						for(var k = 0; k < element.options.length; k++)
						{
							for(var l = 0; l < values.length; l++)
							{
								element.options[k].selected |= (element.options[k].value == values[l]);
							}
						}
						break;

					case 'select':
					case 'select-one':
						element.value = value.toString() || value;
						break;
				}
			}
				
			
		}

	}

	// scroll to submitted form element
	var formElement = document.getElementById('mc4wp-form-' + mc4wp.submittedFormId);

	if(!formElement) { 
		return; 
	}

	if(mc4wp.success == false) {
		populateFields(formElement, mc4wp.postData);
	}

	var scrollToHeight = 0;
	var obj = formElement;
	var windowHeight = window.innerHeight;

    if (obj.offsetParent) {
        do {
            scrollToHeight += obj.offsetTop;
       } while (obj = obj.offsetParent);
    } else {
    	scrollToHeight = formElement.offsetTop;
    }

	if((windowHeight - 100) > formElement.clientHeight) {
		// vertically center the form
		scrollToHeight = scrollToHeight - ((windowHeight - formElement.clientHeight) / 2);
	} else {
		// scroll a little above the form
		scrollToHeight = scrollToHeight - 100;
	}
	
	if(window.jQuery !== undefined) {
		var animationTime = (500 + (scrollToHeight / 2));
		jQuery('html, body').animate({ scrollTop: scrollToHeight }, animationTime);
	} else {
		window.scrollTo(0, scrollToHeight);
	}



})();