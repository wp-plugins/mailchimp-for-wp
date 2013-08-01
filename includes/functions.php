<?php

function mc4wp_checkbox()
{
	$mc4wp = MC4WP::get_instance();

	if($mc4wp->commentSubscriber) {
		$mc4wp->commentSubscriber->output_checkbox();
	}
}

// end of file