  // from http://www.phpletter.com/Demo/Tinymce-Ajax-File-Manager/
 tinyMCE.init({
			mode : "textareas",
			
			theme : "advanced",
			plugins : "advimage,advlink,media,contextmenu",
			theme_advanced_buttons1_add_before : "newdocument,separator",
			theme_advanced_buttons1_add : "fontselect,fontsizeselect",
			theme_advanced_buttons2_add : "separator,forecolor,backcolor,liststyle",
			theme_advanced_buttons2_add_before: "cut,copy,separator,",
			theme_advanced_buttons3_add_before : "",
			theme_advanced_buttons3_add : "media",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			extended_valid_elements : "hr[class|width|size|noshade]",
			file_browser_callback : "ajaxfilemanager",
			paste_use_dialog : false,
			theme_advanced_resizing : true,
			theme_advanced_resize_horizontal : true,
			apply_source_formatting : true,
			force_br_newlines : true,
			force_p_newlines : false,	
			relative_urls : true
		});

		function ajaxfilemanager(field_name, url, type, win) {
			var ajaxfilemanagerurl = "../../../../assets/js/plugins/ajaxfilemanager/ajaxfilemanager.php";
			switch (type) {
				case "image":
					break;
				case "media":
					break;
				case "flash": 
					break;
				case "file":
					break;
				default:
					return false;
			}
            tinyMCE.activeEditor.windowManager.open({
                url: "../../../../assets/js/plugins/ajaxfilemanager/ajaxfilemanager.php",
                width: 1000,
                height: 750,
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
		}



  
 function toggleEditor(id) {
	if (!tinyMCE.get(id))
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}
  