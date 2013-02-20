<?php
/*
Plugin Name: vkWPtools
Plugin URI: http://desarrollogis.dyndns.org/
Description: vkWPtools Plugin.
Version: 1.0
Author: desarrollogis
Author URI: http://desarrollogis.dyndns.org/
License: GPL2
*/

function vkWPtools_options() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	echo '<div class="wrap">';
	echo '<p>Here is where the form would go if I actually had options.</p>';
	echo '</div>';
}

function vkWPtools_menu() {
	add_options_page('vkWPtools Options', 'vkWPtools', 'manage_options', 'vkWPtools', 'vkWPtools_options');
}

add_action('admin_menu', 'vkWPtools_menu');
?>
