=== Plugin Name ===
Contributors: DvanKooten
Donate link: http://dannyvankooten.com/donate/
Tags: mailchimp, newsletter, mailinglist, email, email list, form, widget form, sign-up form, subscribe form, comments, comment form, mailchimp widget, buddypress, multisite
Requires at least: 3.1
Tested up to: 3.6
Stable tag: 1.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Thé ultimate MailChimp plugin to grow your MailChimp e-mail lists. Sign-up forms, checkboxes, it's all in here.

== Description ==

= MailChimp for WordPress =

Want to grow your MailChimp list(s)? Want more control over your sign-up forms? This is the plugin for you.

Easily create and manage sign-up forms and then add them to your posts, pages and widgets by using a simple shortcode. Add a "Sign me up to the newsletter" checkbox to your comment, registration and other forms to make subscribing to your lists effortless for your visitors. 

[Upgrade to MailChimp for WordPress Pro now](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)

**Features:**

* Show sign-up forms in your posts, pages and widgets by using a simple shortcode `[mc4wp-form]`
* Adds a "sign-up to our newsletter" checkbox to ANY form, including your comment and registration forms.
* SPAM protection, no "fake" subscribers will be added to your lists.
* Create and manage sign-up forms in an easy way. No field limit!
* Uses the MailChimp API, blazingly fast and reliable.
* Configuring is easy, all you need is your MailChimp API key.
* Compatible with BuddyPress and MultiSite registration forms.
* Compatible with Contact Form 7, you can use `[mc4wp_checkbox]` inside your CF7 forms.

**Pro Features:**

* AJAX forms (no page reload, fast)
* Multiple sign-up forms for multiple lists
* Field presets for all your list's merge tags which makes it extremely easy to create sign-up forms.
* Subscribers log, gain insight into where and how your visitors subscribe to your lists.
* Premium e-mail support
* No advertisements

[Upgrade to MailChimp for WordPress Pro now](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)

**MailChimp Sign-Up Form**
The plugin comes with an easy to way to build sign-up forms for your MailChimp lists. Add as many fields as you like and customize labels, placeholders, initial value's etc. in a simple way.

Use the `[mc4wp-form]` shortcode to show a sign-up form in your posts, pages or text widgets.

**Sign-Up Checkbox**
Commenters and subscribers are valuable visitors who are most likely interested to be on your mailinglist. This plugin makes it easy for them, all they have to do is check a single checkbox when commenting or registering on your website!

You can add this checkbox to ANY form you like, including Contact Form 7 forms. The plugin will take care of the rest.

== Installation ==

1. In your WordPress admin panel, go to Plugins > New Plugin, search for "MailChimp for WP" and click "Install now"
1. Alternatively, download the plugin and upload the contents of mailchimp-for-wp.zip to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the plugin
1. Fill in your MailChimp API key in the plugin's options.
1. Select at least one list to subscribe visitors to.
1. (Optional) Select to which forms the sign-up checkbox should be added.
1. (Optional) Create a form and show it in your posts, pages or text widgets using the shortcode `[mc4wp-form]`.
1. (Optional) If you like the plugin, upgrade to Pro or donate a beer. :-)

== Frequently Asked Questions ==

= What does this plugin do? =
This plugin gives you the possibility to easily create sign-up forms for your MailChimp lists and show them in various places on your website. Also, this plugin can add a checkbox to your comment and registration form that makes it extremely easy for your visitors to subscribe to your lists.

For a complete list of plugin features, take a look here: [MailChimp for WordPress](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/).

= Why does the checkbox not show up at my comment form? =
Your theme probably does not support the necessary comment hook this plugin uses to add the checkbox to your comment form. You can manually place the checkbox by placing the following code snippet inside the form tags of your theme's comment form.

`<?php if(function_exists('mc4wp_show_checkbox')) { mc4wp_show_checkbox(); }?>`

Your theme folder can be found by browsing to `/wp-content/themes/your-theme-name/`.

= Where can I find my MailChimp API key? =
[http://kb.mailchimp.com/article/where-can-i-find-my-api-key](http://kb.mailchimp.com/article/where-can-i-find-my-api-key)

= How can I style the sign-up form? =
You can use the following CSS selectors to style the sign-up form to your likings. Just add your CSS rules to your theme's stylesheet, usually found in `/wp-content/themes/your-theme-name/style.css`.

`
form.mc4wp-form{ ... } /* the form element */
form.mc4wp-form p { ... } /* form paragraphs */
form.mc4wp-form label { ... } /* labels */
form.mc4wp-form input { ... } /* input fields */
form.mc4wp-form input[type=checkbox] { ... } /* checkboxes */
form.mc4wp-form input[type=submit] { ... } /* submit button */
form.mc4wp-form .mc4wp-alert { ... } /* success & error messages */
form.mc4wp-form .mc4wp-success { ... } /* success message */
form.mc4wp-form .mc4wp-error { ... } /* error messages */
` 

= The shortcode [mc4wp-form] is not working. Why? =
Make sure to go to **form settings** in the plugin settings screen. There you have to check a checkbox that says "load form functionality". This will make the plugin load the necessary code.

= Can I add a checkbox to this third-party form? =
Yes, you can. Go to checkbox and tick the checkbox that says "show checkbox at other forms (manual)". Then, include ANY field with name attribute `mc4wp-try-subscribe` and the plugin will take care of the rest.

Example: 
`<input type="checkbox" name="mc4wp-try-subscribe" value="1" id="mc4wp-checkbox" /><label for="mc4wp-checkbox">Subscribe to our newsletter</label>`

Make sure your form contains an email field with any of the following names: 
`email, e-mail, email_address, your-email` 

Note: when using Contact Form 7 you can use `[mc4wp_checkbox]` inside your CF7 form template to render the checkbox.

= I'm using Contact Form 7 / plugin XYZ with the checkbox, how do I add more MailChimp merge fields? =
Prefix the name attribute with `mc4wp-` and the plugin will send the field value to MailChimp.

Example CF7 code for MailChimp WEBSITE field:
`[text* mc4wp-website]`

Example HTML code:
`<input type="text" name="mc4wp-WEBSITE" /><label>Your website:</label>`

= How do I add subscribers to certain interest groups? =
Use the field wizard. Or, if you know more about HTML, the following snippet should get you started. **Replace `###` with your grouping ID or grouping name**.

`
<input type="hidden" name="GROUPINGS[###]" value="Groupname 1,Groupname 2,Groupname 3" />
`
Or, if you want to use checkboxes...

`
<input type="checkbox" name="GROUPINGS[###][]" value="Group 1" /><label>Group 1</label>
<input type="checkbox" name="GROUPINGS[###][]" value="Group 2" /><label>Group 2</label>
`

= Can I create multiple sign-up forms? =
Sorry, this feature is only available in the premium version of the plugin.

= Can the form be submitted by AJAX so there is no page reload? =
Sorry, this feature is only available in the premium version of the plugin.

== Screenshots ==

1. The MC4WP options page.
1. The MC4WP form options page.
1. Multiple lists in [MailChimp for WordPress Pro](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)
1. Editing a form in [MailChimp for WordPress Pro](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)


== Changelog ==
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