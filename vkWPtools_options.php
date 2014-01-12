<?php
$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
$keys = array();
foreach ($posts as $post) {
	foreach (get_post_custom_keys($post->ID) as $key => $value) {
		$keys[$value] = 0;
	}
}
$themes = array();
if (function_exists('wp_get_themes')) {
	foreach (wp_get_themes(array('errors' => null, 'allowed' => null)) as $theme) {
		$themes[] = array($theme->Template, $theme->Name);
	}
}
else {
	$dir = ABSPATH . 'wp-content/themes';
	$handle = opendir($dir);
	while ($name = readdir($handle)) {
		if (($name[0] == '.') || !is_dir("$dir/$name")) {
			continue;
		}
		$themes[] = array($name, $name);
	}
	closedir($handle);
}
?>
<div class="wrap">
<div id="icon-options-general" class="icon32">
<br />
</div>
<h2>vkWPtools</h2>
<table class="form-table">
<tr>
<th><label for="theme_to_backup">Backup theme:</label></th>
<td>
<select id="theme_to_backup">
<?php foreach ($themes as $theme): ?>
<option value="<?php echo $theme[0]; ?>"><?php echo $theme[1]; ?></option>
<?php endforeach; ?>
</select>
<button id="backup_theme" class="button">Backup</button>
<button id="clean_theme_backups" class="button">Clean backups</button>
</td>
</tr>
<tr>
<th><label for="folder_to_backup">Backup folder:</label></th>
<td>
<input type="text" id="folder_to_backup" size="100" value="wp-content/" />
<button id="list_folder" class="button">List</button>
<button id="backup_folder" class="button">Backup</button>
<button id="clean_folder_backups" class="button">Clean backups</button>
</td>
</tr>
<tr>
<th><label>Backup pages name:</label></th>
<td>
<button id="backup_pages_name" class="button">Backup</button>
<button id="restore_pages_name" class="button">Restore</button>
</td>
</tr>
<tr>
<th><label for="key_to_delete">Delete key:</label></th>
<td>
<select id="key_to_delete">
<option value="">--Select a key--</option>
<?php foreach ($keys as $key => $value): ?>
<option value="<?php echo $key; ?>"><?php echo $key; ?></option>
<?php endforeach; ?>
</select>
<button id="delete_key" class="button">Delete</button>
</td>
</tr>
<tr>
<th>php.ini</th>
<td>
<textarea id="content_phpini" rows="10" cols="50"></textarea>
<button id="load_phpini" class="button">Load</button>
<button id="save_phpini" class="button">Save</button>
</td>
</table>
</div>
