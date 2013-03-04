<?php
$posts = get_posts(array('post_type' => 'page', 'numberposts' => -1));
$keys = array();
foreach ($posts as $post) {
	foreach (get_post_custom_keys($post->ID) as $key => $value) {
		$keys[$value] = 0;
	}
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
				<?php foreach (wp_get_themes(array('errors' => null, 'allowed' => null)) as $theme): ?>
				<option value="<?php echo $theme->Template; ?>"><?php echo $theme->Name; ?></option>
				<?php endforeach; ?>
			</select>
			<button id="backup_theme" class="button">Backup</button>
			<button id="clean_backups" class="button">Clean backups</button>
		</td>
	</tr>
	<tr>
		<th><label>Backup themes name:</label></th>
		<td>
			<button id="backup_themes_name" class="button">Backup</button>
			<button id="restore_themes_name" class="button">Restore</button>
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
	</table>
</div>
