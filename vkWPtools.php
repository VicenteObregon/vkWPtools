<?php
/*
Plugin Name: vkWPtools
Plugin URI: http://desarrollogis.dyndns.org/
Description: vkWPtools Plugin.
Version: 1.02
Author: desarrollogis
Author URI: http://desarrollogis.dyndns.org/
License: GPL2
*/

if (!defined('vkWPtools_DIR')) {
	define('vkWPtools_DIR', ABSPATH . 'wp-content/plugins/vkWPtools/');
}
if (!defined('vkWPtools_URL')) {
	define('vkWPtools_URL', content_url() . '/plugins/vkWPtools/');
}
$directories = array();
$directories[] = vkWPtools_DIR . 'backups';
$directories[] = vkWPtools_DIR . 'backups/themes';
$directories[] = vkWPtools_DIR . 'backups/folders';
foreach ($directories as $directory) {
	if (!is_dir($directory)) {
		mkdir($directory);
	}
}

function vkWPtools_admin_enqueue_scripts() {
	wp_enqueue_script('vkWPtools', vkWPtools_URL . 'vkWPtools.js', array('jquery'));
}

function vkWPtools_options() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges.'));
	include_once(vkWPtools_DIR . 'vkWPtools_options.php');
}

function vkWPtools_menu() {
	add_options_page('vkWPtools Options', 'vkWPtools', 'manage_options', 'vkWPtools', 'vkWPtools_options');
}

function vkWPtools_clean_theme_backups() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges'));
	$directory = vkWPtools_DIR . 'backups/themes';
	chdir($directory);
	$command = "rm -f *.zip";
	exec($command);
	die('Ok');
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
	die($url);
}

function vkWPtools_clean_folder_backups() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges'));
	$directory = vkWPtools_DIR . 'backups/folders';
	chdir($directory);
	$command = "rm -f *.zip";
	exec($command);
	die('Ok');
}

function vkWPtools_backup_folder() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges'));
	$folder = $_POST['folder'];
	$directory = dirname(ABSPATH . $folder);
	$folder = basename(ABSPATH . $folder);
	chdir($directory);
	$filename = vkWPtools_DIR . "backups/folders/{$folder}.zip";
	$command = "zip -r \"{$filename}\" \"{$folder}\" -x \"{$folder}\"/.git\\* \"{$folder}\"\\*.sh";
	exec($command);
	$url = vkWPtools_URL . "backups/folders/{$folder}.zip";
	die($url);
}

function vkWPtools_list_folder() {
	current_user_can('manage_options') or wp_die(__('Insufficient privileges'));
	$folder = $_POST['folder'];
	$directory = ABSPATH . $folder;
	$list = array();
	$dir = $directory;
	$handle = opendir($dir);
	while ($name = readdir($handle)) {
		if (in_array($name, array('.', '..'))) {
			continue;
		}
		$list[] = $name;
	}
	closedir($handle);
	$list = implode("\n", $list);
	die($list);
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

add_action('admin_enqueue_scripts', 'vkWPtools_admin_enqueue_scripts');
add_action('admin_menu', 'vkWPtools_menu');
add_action('wp_ajax_vkWPtools_backup_theme', 'vkWPtools_backup_theme');
add_action('wp_ajax_vkWPtools_backup_folder', 'vkWPtools_backup_folder');
add_action('wp_ajax_vkWPtools_list_folder', 'vkWPtools_list_folder');
add_action('wp_ajax_vkWPtools_clean_theme_backups', 'vkWPtools_clean_theme_backups');
add_action('wp_ajax_vkWPtools_clean_folder_backups', 'vkWPtools_clean_folder_backups');
add_action('wp_ajax_vkWPtools_backup_pages_name', 'vkWPtools_backup_pages_name');
add_action('wp_ajax_vkWPtools_restore_pages_name', 'vkWPtools_restore_pages_name');
add_action('wp_ajax_vkWPtools_delete_key', 'vkWPtools_delete_key');
?>
