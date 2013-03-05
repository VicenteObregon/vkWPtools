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

if (!defined('vkWPtools_DIR'))
	define('vkWPtools_DIR', ABSPATH . 'wp-content/plugins/vkWPtools/');
if (!defined('vkWPtools_URL'))
	define('vkWPtools_URL', content_url() . '/plugins/vkWPtools/');
$directories = array();
$directories[] = vkWPtools_DIR . 'backups';
$directories[] = vkWPtools_DIR . 'backups/themes';
foreach ($directories as $directory) {
	if (!is_dir($directory))
		mkdir($directory);
}

function vkWPtools_options() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges.'));
	wp_enqueue_script('vkWPtools', vkWPtools_URL . 'vkWPtools.js', array('jquery'));
	include_once(vkWPtools_DIR . 'vkWPtools_options.php');
}

function vkWPtools_menu() {
	add_options_page('vkWPtools Options', 'vkWPtools', 'manage_options', 'vkWPtools', 'vkWPtools_options');
}

function vkWPtools_clean_backups() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges'));
	$directory = vkWPtools_DIR . 'backups/themes';
	chdir($directory);
	$command = "rm -f *.zip";
	exec($command);
	wp_die('Ok');
}

function vkWPtools_backup_theme() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges'));
	$theme = $_POST['theme'];
	$directory = dirname(dirname(vkWPtools_DIR)) . '/themes';
	chdir($directory);
	$filename = vkWPtools_DIR . "backups/themes/{$theme}.zip";
	$command = "zip -r \"{$filename}\" {$theme} -x {$theme}/.git\\* {$theme}\\*.sh";
	exec($command);
	$url = vkWPtools_URL . "backups/themes/{$theme}.zip";
	wp_die($url);
}

function vkWPtools_backup_pages_name() {
	current_user_can('edit_others_pages') or wp_die(__('Cannot edit other\'s pages'));
	$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
	foreach ($posts as $post) {
		$title = get_post_meta($post->ID, '_vkWPtools_page_name', true);
		if ($title == $post->post_title)
			continue;
		echo get_the_title($post->ID) . ' = ' . update_post_meta($post->ID, '_vkWPtools_page_name', $post->post_title). "\n";
	}
	wp_die('Ok');
}

function vkWPtools_restore_pages_name() {
	current_user_can('edit_others_pages') or wp_die(__('Cannot edit other\'s pages'));
	$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
	foreach ($posts as $post) {
		$title = get_post_meta($post->ID, '_vkWPtools_page_name', true);
		if ($title == $post->post_title)
			continue;
		echo get_the_title($post->ID) . ' = ' . wp_update_post(array('ID' => $post->ID, 'post_title' => $title)) . "\n";
	}
	wp_die('Ok');
}

function vkWPtools_delete_key() {
	current_user_can('edit_others_pages') or wp_die(__('Cannot edit other\'s pages'));
	$key = $_POST['key'];
	$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
	foreach ($posts as $post) {
		delete_post_meta($post->ID, $key);
	}
	wp_die('Ok');
}

add_action('admin_menu', 'vkWPtools_menu');
add_action('wp_ajax_vkWPtools_backup_theme', 'vkWPtools_backup_theme');
add_action('wp_ajax_vkWPtools_clean_backups', 'vkWPtools_clean_backups');
add_action('wp_ajax_vkWPtools_backup_pages_name', 'vkWPtools_backup_pages_name');
add_action('wp_ajax_vkWPtools_restore_pages_name', 'vkWPtools_restore_pages_name');
add_action('wp_ajax_vkWPtools_delete_key', 'vkWPtools_delete_key');
?>
