=== Plugin Name ===
Contributors: DvanKooten
Donate link: http://dannyvankooten.com/donate/
Tags: mailchimp, newsletter, mailinglist, checkbox, email, mailchimp api,email list
Requires at least: 3.1
Tested up to: 3.5.1
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a checkbox to your comment form to add commenters to your MailChimp e-mail list(s).

== Description ==

= MailChimp for WordPress =

This plugin is an easy way to turn commenters into subscribers of your MailChimp mailing list(s). Fill in your API key, select the lists you want commenters to be subscribed to and you're done. 

Commenters can be subscribed to your mailinglist(s) by just checking 1 simple checkbox.

**Features:**

* Adds a "sign-up to our newsletter" checkbox to your comment form or registration form
* Spam comments will be ignored.
* Uses the MailChimp API, blazingly fast and reliable.
* Configuring is extremely easy because of the way this plugin is set-up, all you need is your MailChimp API key.
* Compatible with BuddyPress and MultiSite registration forms

**More info:**

* [MailChimp for WordPress](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/)
* Check out more [WordPress plugins](http://dannyvankooten.com/wordpress-plugins/) by Danny van Kooten
* You should follow [Danny on Twitter](http://twitter.com/DannyvanKooten) for lightning fast support and updates.

== Installation ==

1. Upload the contents of newsletter-sign-up.zip to your plugins directory.
1. Activate the plugin
1. Fill in your MailChimp API key in the plugin's options.

== Frequently Asked Questions ==

= What does this plugin do? =
This plugin adds a checkbox to your comment form that makes it easy for commenters to subscribe to your MailChimp newsletter. All they have to do is check one checkbox and they will be added to your mailinglist(s).

For a complete list of plugin features, take a look here: [MailChimp for WordPress](http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/).

= Why does the checkbox not show up? =
Your theme probably does not support the necessary comment hook this plugin uses to add the checkbox to your comment form. You can manually place the checkbox by calling `<?php do_action('comment_form') ?>` inside the form tags of your theme's comment form. Usually this file can be found in your theme folder as `comments.php`. Your theme folder can be found by browsing to `/wp-content/themes/your-theme-name/`.

== Screenshots ==

1. The MC4WP options page.

== Changelog ==
= 0.4 =
* Changed: dashboard now has different tabs for the different settings.
* Fixed: debugging statements
* Added: settings link on plugin page

= 0.3 =
* Fixed the missing argument bug when submitting a comment for some users.
* Added support for regular, BuddyPress and MultiSite registration forms.

= 0.2 =
* Fixed small bug where name of comment author was not correctly assigned
* Improved CSS reset for checkbox

= 0.1 =
* BETA release