<div class="wrap">
	<div id="icon-options-general" class="icon32">
		<br />
	</div>
	<h2>vkWPtools Options</h2>
	<table class="form-table">
	<tr>
		<th><label for="theme_to_backup">Backup theme:</label></th>
		<td>
			<select id="theme_to_backup">
				<?php foreach (wp_get_themes(array('errors' => null, 'allowed' => null)) as $theme): ?>
				<option value="<?php echo $theme->Template; ?>"><?php echo $theme->Name; ?></option>
				<?php endforeach; ?>
			</select>
			<button id="backup_theme">Backup</button>
			<button id="clean_backups">Clean backups</button>
		</td>
	</tr>
	<tr>
		<th><label>Backup themes name:</label></th>
		<td>
			<button id="backup_themes_name">Backup</button>
			<button id="restore_themes_name">Restore</button>
		</td>
	</table>
</div>
