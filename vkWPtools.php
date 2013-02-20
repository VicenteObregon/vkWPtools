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

if (!defined('WP_CONTENT_DIR'))
	define('WP_CONTENT_DIR', ABSPATH . 'wp-content');
mkdir(WP_CONTENT_DIR . '/vkWPtools');
mkdir(WP_CONTENT_DIR . '/vkWPtools/backups');
mkdir(WP_CONTENT_DIR . '/vkWPtools/backups/themes');

function vkWPtools_options() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	include_once(dirname(__FILE__) . '/admin/options.php');
}

function vkWPtools_menu() {
	add_options_page('vkWPtools Options', 'vkWPtools', 'manage_options', 'vkWPtools', 'vkWPtools_options');
}

function vkWPtools_backup_theme() {
	$theme = $_POST['theme'];
	die($theme);
}

add_action('admin_menu', 'vkWPtools_menu');
add_action('wp_ajax_vkWPtools_backup_theme', 'vkWPtools_backup_theme');
?>
