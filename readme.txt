=== Plugin Name ===
Contributors: DvanKooten
Donate link: http://dannyvankooten.com/donate/
Tags: mailchimp, newsletter, mailinglist, email, email list, form, widget form, sign-up form, subscribe form, comments, comment form, mailchimp widget, buddypress, multisite
Requires at least: 3.1
Tested up to: 3.6.1
Stable tag: 1.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The best MailChimp plugin to get more email subscribers. Easily add sign-up forms and sign-up checkboxes to your WordPress website.

== Description ==

= MailChimp for WordPress =

Want to get more email subscribers for your MailChimp lists? This plugin will be a BIG help by showing sign-up forms and sign-up checkboxes on your WordPress website.

Easily build sign-up forms and then add them to your posts, pages and widget areas by using a simple shortcode `[mc4wp-form]`. 

Add "sign up to our newsletter" checkboxes to your comment form, registration form or other forms, making subscribing to your list(s) effortless for your visitors.  

*This plugin has a premium version: [upgrade to MailChimp for WordPress Pro now >>](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)*

**Plugin Features**

* Show sign-up forms in your posts, pages and widgets by using a simple shortcode `[mc4wp-form]`
* Adds a "sign-up to our newsletter" checkbox to ANY form, including your comment and registration forms.
* SPAM protection, no "fake" subscribers will be added to your lists.
* Create and manage sign-up forms in an easy way. No field limit!
* Uses the MailChimp API, blazingly fast and reliable.
* Configuring is easy, all you need is your MailChimp API key.
* Compatible with [BuddyPress](http://buddypress.org/) and WordPress MultiSite registration forms.
* Compatible with [bbPress](http://bbpress.org/), add a newsletter checkbox to the new topic and new reply forms.
* Compatible with [Contact Form 7](http://contactform7.com/), you can use `[mc4wp_checkbox]` inside your CF7 forms.

**Premium Features**

* AJAX sign-up forms, so the page doesn't have to reload when clicking submit.
* Multiple sign-up forms for multiple lists
* Field presets for all your list's merge tags which makes it extremely easy to create sign-up forms.
* Subscribers log, keep track of all sign-ups
* Statistical charts, gain valuable insights when and how your visitors subscribed.
* Built-in integration with [WooCommerce](http://www.woocommerce.com/) and [Easy Digital Downloads](https://easydigitaldownloads.com?ref=2123) for adding sign-up checkboxes to your checkout forms.
* Premium support

[Upgrade to MailChimp for WordPress Pro now >>](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)

= MailChimp Sign-Up Form =
The plugin comes with an easy to way to build sign-up forms for your MailChimp lists. Add as many fields as you like and customize labels, placeholders, initial value's etc. in a simple way.

Use the `[mc4wp-form]` shortcode to show a sign-up form in your posts, pages or text widgets.

= "Sign-up to our newsletter?" Checkboxes =
People who comment or register on your website are valuable visitors and most likely interested to be on your mailinglist as well. This plugin makes it easy for them to subscribe to your MailChimp lists, one mouse-click is all they need.

You can add sign-up checkboxes to ANY form you like, including Contact Form 7 forms.

= Simple but extremely flexible =
Plugins should be flexible but simple. This plugin was developed with that in mind. Most settings are optional, making configuration of the plugin really simple. However, if you are more tech-savvy the plugin has plenty of customization options. 


== Installation ==

1. In your WordPress admin panel, go to Plugins > New Plugin, search for "MailChimp for WP" and click "Install now"
1. Alternatively, download the plugin and upload the contents of mailchimp-for-wp.zip to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin
1. Set your MailChimp API key in the plugin settings.
1. Select at least one list to subscribe visitors to.
1. (Optional) Select to which forms the sign-up checkbox should be added.
1. (Optional) Create a form and show it in your posts, pages or text widgets using the shortcode `[mc4wp-form]`.
1. (Optional) If you like the plugin, upgrade to [MailChimp for WordPress Pro](dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/) for an even better plugin or donate a beer. Much appreciated!


== Frequently Asked Questions ==

= Is there a premium version of this plugin? =
Yes, there is and it is awesome. Pro features include:

1. (Multiple) AJAX Sign-up Forms (so the page doesn't reload after clicking the submit button)
1. Statistical charts, learn when and how your visitors subscribed.
1. Subscriber logging, keep track of everyone who subscribes and where they subscribed from.
1. Easier form creation: presets for all your merge fields
1. Sign-up checkbox integration with WooCommerce and Easy Digital Downloads
1. Custom individual checkbox labels
1. Premium support

[Upgrade to MailChimp for WordPress Pro now >>](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)

= How can I style the sign-up form? =
You can use CSS to style the sign-up form. Use the following CSS selectors.

`
form.mc4wp-form{ ... } /* the form element */
form.mc4wp-form p { ... } /* form paragraphs */
form.mc4wp-form label { ... } /* labels */
form.mc4wp-form input { ... } /* input fields */
form.mc4wp-form input[type="checkbox"] { ... } /* checkboxes */
form.mc4wp-form input[type="submit"] { ... } /* submit button */
form.mc4wp-form .mc4wp-alert { ... } /* success & error messages */
form.mc4wp-form .mc4wp-success { ... } /* success message */
form.mc4wp-form .mc4wp-error { ... } /* error messages */
` 

Just add your CSS rules to your theme stylesheet, **/wp-content/themes/your-theme-name/style.css**.

= Where can I find my MailChimp API key? =
[http://kb.mailchimp.com/article/where-can-i-find-my-api-key](http://kb.mailchimp.com/article/where-can-i-find-my-api-key)

= How to add a sign-up checkbox to my Contact Form 7 forms? =
Use the following shortcode to render a sign-up checkbox in your CF7 forms. 

`[mc4wp_checkbox "My custom label text"]`

If you need more data for your merge fields, prefix the field name with `mc4wp-`.

*Example CF7 template for MailChimp WEBSITE field*
`
[text* mc4wp-WEBSITE]
`

= Can I add a checkbox to a third-party form? =
Yes, you can. Go to MailChimp for WP > Checkbox Settings and tick the "show checkbox at other forms (manual)" checkbox. Then, include a checkbox with name attribute `mc4wp-try-subscribe` and value `1` in your form.


*Example HTML for checkbox in third-party form*
`
<input type="checkbox" name="mc4wp-try-subscribe" value="1" /><label>Subscribe to our newsletter?</label>
`

If you need to send more data for your list merge fields, prefix the name attribute with **mc4wp-**. The plugin will look for fields prefixed with `mc4wp-` and send the field values to MailChimp.

*Example HTML code for MailChimp WEBSITE merge tag*
`<input type="text" name="mc4wp-WEBSITE" /><label>Your website:</label>`

= How do I add subscribers to certain interest groups? =
Use the field wizard. Or, if you know more about HTML, the following snippet should get you started. *Replace `###` with your grouping ID or grouping name.*

`
<input type="hidden" name="GROUPINGS[###]" value="Groupname 1,Groupname 2,Groupname 3" />
`
Or, if you want to use checkboxes...

`
<input type="checkbox" name="GROUPINGS[###][]" value="Group 1" /><label>Group 1</label>
<input type="checkbox" name="GROUPINGS[###][]" value="Group 2" /><label>Group 2</label>
`

= Why does the checkbox not show up at my comment form? =
Your theme probably does not support the necessary comment hook this plugin uses to add the checkbox to your comment form. You can manually place the checkbox by placing the following code snippet inside the form tags of your theme's comment form.

`<?php if(function_exists('mc4wp_show_checkbox')) { mc4wp_show_checkbox(); }?>`

Your theme folder can be found by browsing to `/wp-content/themes/your-theme-name/`.

== Screenshots ==

1. The MailChimp for WP settings pages.
2. Add a sign-up checkbox to various places on your website.
3. An example sign-up checkbox.
4. An example sign-up form in my footer on dannyvankooten.com. More [MailChimp sign-up form examples](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/demo-sign-up-forms/) are available on my website.
5. You can create multiple sign-up forms in [MailChimp for WordPress Pro](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)
6. Editing a form got a lot easier in the premium version.
7. Gain valuable insights which method your visitors used to subscribe for any given time period using beautiful line charts. (Premium version only)


== Changelog ==
= 1.1.4 =
* Fixed: usage of textarea elements in the form mark-up for WP3.3+.

= 1.1.3 =
* Added: first and lastname to registration hook, works with Register Redux Plus for example.

= 1.1.2 =
* Fixed: field wizard initial value not being set in some browsers
* Fixed: CF7 checkbox subscribing everyone regardless of checkbox setting
* Added: bbPress compatibility, you can now add a sign-up checkbox to the new topic and new reply forms
* Improved: various code and debug improvements
* Improved: field wizard now wraps radio inputs and checkboxes in a label
* Improved: Usability when using sign-up checkbox with Contact Form 7
* Removed: form usage option

= 1.1.1 =
* Fixed warning for BuddyPress sites

= 1.1 =
* Fixed: spam comments not being filtered
* Fixed: Automatic splitting of NAME into FNAME and LNAME
* Added: HTML 5 url, tel and date fields to field wizard
* Added: Form variables for usage inside form mark-up.
* Improved: default form CSS
* Improved: Contact Form 7 integration

= 1.0.3 =
* Added HTML quicktags to form markup textarea.
* Added option to set custom label when using Contact Form 7 shortcode `[mc4wp_checkbox "Your checkbox label"]`
* Added HTML comments
* Added upgrade link to plugins overview
* Improved compatibility with third-party plugins when using checkbox, smarter e-mail field guessing
* Improved: easier copying of the form shortcode from form settings pages
* Added: uninstall function

= 1.0.2 =
* Improved code, less memory usage
* Added `mc4wp_show_form()` function for usage inside template files

= 1.0.1 =
* Changed: format for groups is now somewhat easier. Refer to the FAQ and update your form mark-up please. (Backwards compatibility included)
* Added: group preset to form field wizard for hidden fields, checkboxes and radio inputs.
* Added: radio inputs to field wizard
* Improved: the field wizard will now add labels after the checkbox and radio input elements.
* Fixed: regular error messages not being shown in some cases.

= 1.0 =
* Added support for group checkboxes
* Added support for paragraph elements in error and success messages, the messages are now wrapped in `<div>` instead. Update your custom CSS rules
* Added some translation filters for qTranslate and WPML compatibility.

= 0.8.3 =
* Added: Guess first and last name when only using full name field.
* Added: Links to [MailChimp for WordPress Pro](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)
* Fixed: Bug where options could not be saved after adding specific HTML tags to the form mark-up.

= 0.8.2 =
* Improved: Namespaced form CSS classes
* Improved: Improved error messages
* Improved: It is now easier to add fields to your form mark-up by using the wizard. You can choose presets etc.
* Improved: All field names that are of importance for MailChimp should now be uppercased (backwards compatibility is included)
* Improved: Fields named added through the wizard are now validated and sanitized
* Improved: Added caching to the backend which makes it way faster
* Improved: Various usability improvements

= 0.8.1 =
* Fixed: typo in form success message
* Improved: various little improvements
* Added: option to hide the form after a successful sign-up

= 0.8 =
* Changed links to show your appreciation for this plugin.
* Changed function name, `mc4wp_checkbox()` is now `mc4wp_show_checkbox()` (!!!)
* Improved: CSS reset now works for registration forms as well.
* Improved: Code, removed unnecessary code, only load classes when not existing yet, etc.
* Improved: hooked into user_register to allow third-party registration form plugins.
* Added: Shortcode for usage inside Contact Form 7 form templates `[mc4wp_checkbox]`
* Added: Catch-all, hook into ANY form using ANY input field with name attribute `mc4wp-try-subscribe` and value `1`.
* Fixed: Subscribe from Multisite sign-up
* Fixed: 404 page when no e-mail given.


= 0.7 =
* Improved: small backend JavaScript improvements / fixes
* Improved: configuration tabs on options page now work with JavaScript disabled as well
* Added: form and checkbox can now subscribe to different lists
* Added: Error messages for WP Administrators (for debugging)
* Added: `mc4wp_show_checkbox()` function to manually add the checkbox to a comment form.

= 0.6.2 =
* Fixed: Double quotes now enabled in text labels and success / error messages (which enables the use of JavaScript)
* Fixed: Sign-up form failing silently without showing error.

= 0.6.1 =
* Fixed: error notices
* Added: some default CSS for success and error notices
* Added: notice when form mark-up does not contain email field

= 0.6 =
* Fixed: cannot redeclare class MCAPI
* Fixed: scroll to form element
* Added: notice when copying the form mark-up instead of using `[mc4wp-form]`
* Added: CSS classes to form success and error message(s).
* Removed: Static element ID on form success and error message(s) for W3C validity when more than one form on 1 page.

= 0.5 =
* Fixed W3C invalid value "true" for attribute "required"
* Added scroll to form element after form submit.
* Added option to redirect visitors after they subscribed using the sign-up form.

= 0.4.1 =
* Fixed correct and more specific error messages
* Fixed form designer, hidden fields no longer wrapped in paragraph tags
* Added text fields to form designer
* Added error message when email address was already on the list
* Added debug message when there is a problem with one of the (required) merge fields

= 0.4 =
* Improved dashboard, it now has different tabs for the different settings.
* Improved guessing of first and last name.
* Fixed debugging statements on settings page
* Added settings link on plugins overview page
* Added form functionality
* Added form shortcode
* Added necessary filters for shortcodes to work inside text widgets
* Added spam honeypot to form to ignore bot sign-ups
* Added error & success messages to form
* Added Freddy icon to menu

= 0.3 =
* Fixed the missing argument bug when submitting a comment for some users.
* Added support for regular, BuddyPress and MultiSite registration forms.

= 0.2 =
* Fixed small bug where name of comment author was not correctly assigned
* Improved CSS reset for checkbox

= 0.1 =
* BETA release

== Upgrade Notice ==

= 1.1.1 =
Bugfix for BuddyPress sites