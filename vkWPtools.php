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
$directories = array();
$directories[] = WP_CONTENT_DIR . '/vkWPtools';
$directories[] = WP_CONTENT_DIR . '/vkWPtools/backups';
$directories[] = WP_CONTENT_DIR . '/vkWPtools/backups/themes';
foreach ($directories as $directory) {
	if (!is_dir($directory))
		mkdir($directory);
}

function vkWPtools_options() {
	if (!current_user_can('manage_options')) {
		wp_die(__('You do not have sufficient permissions to access this page.'));
	}
	include_once(dirname(__FILE__) . '/admin/options.php');
}

function vkWPtools_menu() {
	add_options_page('vkWPtools Options', 'vkWPtools', 'manage_options', 'vkWPtools', 'vkWPtools_options');
}

function vkWPtools_clean_backups() {
	$directory = WP_CONTENT_DIR . '/vkWPtools/backups/themes';
	$command = "rm -f \"{$directory}\"/*.zip";
	exec($command);
	die('ok');
}

function vkWPtools_backup_theme() {
	$theme = $_POST['theme'];
	$directory = WP_CONTENT_DIR . '/themes/';
	chdir($directory);
	$filename = WP_CONTENT_DIR . "/vkWPtools/backups/themes/{$theme}.zip";
	$command = "zip -r \"{$filename}\" {$theme} -x {$theme}/.git\\* {$theme}\\*.sh";
	exec($command);
	$url = content_url() . "/vkWPtools/backups/themes/{$theme}.zip";
	die($url);
}

add_action('admin_menu', 'vkWPtools_menu');
add_action('wp_ajax_vkWPtools_backup_theme', 'vkWPtools_backup_theme');
add_action('wp_ajax_vkWPtools_clean_backups', 'vkWPtools_clean_backups');
?>
