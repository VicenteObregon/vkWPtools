<script type="text/javascript">
jQuery(document).ready(function($) {
	var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";

	$("#backup_theme").click(function () {
		var theme = $("#theme_to_backup").val();

		$(this).attr("disabled", "disabled");
		$.post(ajaxurl, { "action": "vkWPtools_backup_theme", "theme": theme }, function(response) {
			alert(response);
			$("#backup_theme").removeAttr("disabled");
		});
	});
	$("#clean_backups").click(function () {
		$(this).attr("disabled", "disabled");
		$.post(ajaxurl, { "action": "vkWPtools_clean_backups" }, function(response) {
			alert(response);
			$("#clean_backups").removeAttr("disabled");
		});
	});
});
</script>
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
	</table>
</div>
