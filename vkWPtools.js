
var ajaxurl = ajaxurl || "";

jQuery(document).ready(function($) {
    $("#backup_theme").click(function() {
        var theme = $("#theme_to_backup").val();

        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_backup_theme", "theme": theme }, function(response) {
            alert(response);
            $("#backup_theme").removeAttr("disabled");
        });
    });
    $("#clean_theme_backups").click(function() {
        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_clean_theme_backups" }, function(response) {
            alert(response);
            $("#clean_theme_backups").removeAttr("disabled");
        });
    });
    $("#list_folder").click(function() {
        var folder = $("#folder_to_backup").val();

        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_list_folder", "folder": folder }, function(response) {
            alert(response);
            $("#list_folder").removeAttr("disabled");
        });
    });
    $("#backup_folder").click(function() {
        var folder = $("#folder_to_backup").val();

        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_backup_folder", "folder": folder }, function(response) {
            alert(response);
            $("#backup_folder").removeAttr("disabled");
        });
    });
    $("#clean_folder_backups").click(function() {
        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_clean_folder_backups" }, function(response) {
            alert(response);
            $("#clean_folder_backups").removeAttr("disabled");
        });
    });
    $("#backup_pages_name").click(function() {
        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_backup_pages_name" }, function(response) {
            alert(response);
            $("#backup_pages_name").removeAttr("disabled");
        });
    });
    $("#restore_pages_name").click(function() {
        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_restore_pages_name" }, function(response) {
            alert(response);
            $("#restore_pages_name").removeAttr("disabled");
        });
    });
    $("#delete_key").click(function() {
        var key = $("#key_to_delete").val();

        if (key == "")
            return;
        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_delete_key", "key": key }, function(response) {
            alert(response);
            $("#key_to_delete option[value=\"" + key + "\"]").remove();
            $("#delete_key").removeAttr("disabled");
        });
    });
    $("#load_phpini").click(function() {
        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_load_phpini" }, function(response) {
	    $("#content_phpini").val(response);
            $("#load_phpini").removeAttr("disabled");
        });
    });
    $("#save_phpini").click(function() {
        var content = $("#content_phpini").val();

        $(this).attr("disabled", "disabled");
        $.post(ajaxurl, { "action": "vkWPtools_save_phpini", "content": content }, function(response) {
	alert(response);
            $("#save_phpini").removeAttr("disabled");
        });
    });
});
