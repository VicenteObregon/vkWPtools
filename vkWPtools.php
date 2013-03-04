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
	wp_enqueue_script('vkWPtools', content_url() . '/plugins/vkWPtools/vkWPtools.js', array('jquery'));
	include_once(dirname(__FILE__) . '/vkWPtools_options.php');
}

function vkWPtools_menu() {
	add_options_page('vkWPtools Options', 'vkWPtools', 'manage_options', 'vkWPtools', 'vkWPtools_options');
}

function vkWPtools_clean_backups() {
	$directory = WP_CONTENT_DIR . '/vkWPtools/backups/themes';
	$command = "rm -f \"{$directory}\"/*.zip";
	exec($command);
	die('Ok');
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

function vkWPtools_backup_themes_name() {
	$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
	foreach ($posts as $post) {
		$title = get_post_meta($post->ID, '_vkWPtools_theme_name', true);
		if ($title == $post->post_title)
			continue;
		echo get_the_title($post->ID) . ' = ' . update_post_meta($post->ID, '_vkWPtools_theme_name', $post->post_title). "\n";
	}
	die('Ok');
}

function vkWPtools_restore_themes_name() {
	$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
	foreach ($posts as $post) {
		$title = get_post_meta($post->ID, '_vkWPtools_theme_name', true);
		if ($title == $post->post_title)
			continue;
		echo get_the_title($post->ID) . ' = ' . wp_update_post(array('ID' => $post->ID, 'post_title' => $title)) . "\n";
	}
	die('Ok');
}

function vkWPtools_delete_key() {
	$key = $_POST['key'];
	$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
	foreach ($posts as $post) {
		delete_post_meta($post->ID, $key);
	}
	die('Ok');
}

add_action('admin_menu', 'vkWPtools_menu');
add_action('wp_ajax_vkWPtools_backup_theme', 'vkWPtools_backup_theme');
add_action('wp_ajax_vkWPtools_clean_backups', 'vkWPtools_clean_backups');
add_action('wp_ajax_vkWPtools_backup_themes_name', 'vkWPtools_backup_themes_name');
add_action('wp_ajax_vkWPtools_restore_themes_name', 'vkWPtools_restore_themes_name');
add_action('wp_ajax_vkWPtools_delete_key', 'vkWPtools_delete_key');
?>
