<?php

if(!function_exists('mc4wp_show_checkbox')) {
	function mc4wp_show_checkbox()
	{
		MC4WP_Lite::checkbox()->output_checkbox();
	}
}

if(!function_exists('mc4wp_show_form')) { 
	function mc4wp_show_form() 
	{
		echo do_shortcode('[mc4wp-form]');
	}
}


// end of file