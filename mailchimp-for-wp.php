<?php
/*
Plugin Name: MailChimp for WP Lite
Plugin URI: http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/
Description: MailChimp integration for WordPress, Lite. Add newsletter subscribe checkboxes to various forms. Create sign-up forms and show them in your posts, pages or widgets. <strong>Pro features:</strong> AJAX forms, easy merge var fields, subscriber logging and way more. <a href="http://dannyvankooten.com/wordpress-plugins/mailchimp-for-wordpress/">Upgrade to Pro now &raquo;</a>
Version: 1.1.1
Author: Danny van Kooten
Author URI: http://dannyvanKooten.com
License: GPL v3

MailChimp for WordPress
Copyright (C) 2012-2013, Danny van Kooten, hi@dannyvankooten.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

define("MC4WP_LITE_VERSION", "1.1.1");

// frontend AND backend
require 'includes/MC4WP_Lite.php';
new MC4WP_Lite();