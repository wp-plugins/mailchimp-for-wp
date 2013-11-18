<?php
/*
Plugin Name: MailChimp for WordPress Lite
Plugin URI: http://dannyvankooten.com/mailchimp-for-wordpress/
Description: Lite version of MailChimp for WordPress. Add various sign-up methods to your website. Show sign-up forms in your posts, pages or widgets. Add sign-up checkboxes to various forms, like your comment or contact forms. Premium features include multiple and better forms, easier styling, detailed statistics and much more: <a href="http://dannyvankooten.com/mailchimp-for-wordpress/">Upgrade now</a>
Version: 1.4.3
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

defined( 'ABSPATH' ) OR exit;

define("MC4WP_LITE_VERSION", "1.4.3");
define("MC4WP_LITE_PLUGIN_DIR", plugin_dir_path(__FILE__));

if(!function_exists('is_plugin_active')) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
}

// Only load Lite plugin is Pro version is not active
if(!is_plugin_active('mailchimp-for-wp-pro/mailchimp-for-wp-pro.php')) {
	include_once MC4WP_LITE_PLUGIN_DIR . 'includes/MC4WP_Lite.php';
	new MC4WP_Lite();
} 

