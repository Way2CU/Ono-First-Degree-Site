/**
 * Main JavaScript
 * Site Name
 *
 * Copyright (c) 2015. by Way2CU, http://way2cu.com
 * Authors:
 */

// create or use existing site scope
var Site = Site || {};

// make sure variable cache exists
Site.variable_cache = Site.variable_cache || {};


/**
 * Check if site is being displayed on mobile.
 * @return boolean
 */
Site.is_mobile = function() {
	var result = false;

	// check for cached value
	if ('mobile_version' in Site.variable_cache) {
		result = Site.variable_cache['mobile_version'];

	} else {
		// detect if site is mobile
		var elements = document.getElementsByName('viewport');

		// check all tags and find `meta`
		for (var i=0, count=elements.length; i<count; i++) {
			var tag = elements[i];

			if (tag.tagName == 'META') {
				result = true;
				break;
			}
		}

		// cache value so next time we are faster
		Site.variable_cache['mobile_version'] = result;
	}

	return result;
};

/**
 * Handle clicking on button which shows contact form.
 * @param object event
 */
Site.handle_show_dialog_click = function(event) {
	event.preventDefault();
	Site.dialog_form.open();
};

/**
 * Handle clicking on submit button in dialog.
 * @param object event
 */
Site.handle_submit_click = function(event) {
	event.preventDefault();
	Caracal.ContactForm.list[0]._form.submit();
};

/**
 * Handle successful data submision.
 * @param object response_data
 */
Site.handle_submit_success = function(response_data) {
	if (!data.error)
		return;

	// send analytics event
	window.dataLayer = window.dataLayer || new Object();
	window.dataLayer.push({'event': 'leadSent'});
};

/**
 * Function called when document and images have been completely loaded.
 */
Site.on_load = function() {
	if (Site.is_mobile())
		Site.mobile_menu = new Caracal.MobileMenu();

	// This button replaceses standard submit button in dialog form
	Site.submit_button = document.createElement('a');
	Site.submit_button.innerHTML = language_handler.getText(null, 'submit');
	Site.submit_button.addEventListener('click', Site.handle_submit_click);

	// dialog which contains form
	Site.dialog_form = new Caracal.Dialog();
	Site.dialog_form
		.set_content_from_dom('div#contact_dialog')
		.add_class('dialog_form')
		.add_control(Site.submit_button)
		.set_title(language_handler.getText(null, 'form_title'));

	// open form in dialog
	Site.show_dialog_button = document.querySelector('a.form');
	Site.show_dialog_button.addEventListener('click', Site.handle_show_dialog_click);

	// lightbox for partners images
	Site.lightbox = new LightBox('section#partners a.image', true, false, true);

	// handle analytics event
	for (var i=0, count=Caracal.ContactForm.list.length; i<count; i++)
		Caracal.ContactForm.list[i].events.connect('submit-success', Site.handle_submit_success);
};


// connect document `load` event with handler function
$(Site.on_load);
