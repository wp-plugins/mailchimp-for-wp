<?php

function mc4wp_show_checkbox()
{
	$mc4wp = MC4WP::get_instance();

	if($mc4wp->checkbox) {
		$mc4wp->checkbox->output_checkbox();
	}
}

// end of file