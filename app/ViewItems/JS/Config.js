$(window).ready (function () {
	/**
	 * Calls the AJAX update method of the config page controller in order to
	 * save changes.
	 * 
	 * @param {Object} config dictionary of updated config(s)
	 * @param {Node}   $this  control being used to update this config
	 */
	function ajaxUpdateConfigs (config, $this) {
		$($this).attr ("disabled", true);
		
		$.ajax ({
			url: "ajax/Controllers/Config/ajaxUpdateConfigs",
			method: "POST",
			data: {
				config: JSON.stringify (config)
			}
		}).done (function () {
			$($this).attr ("disabled", false);
		});
	}
	
	$("#directory_structure").change (function () {
		var config = {
			"directory_structure" : $("#directory_structure").val ()
		};
		
		ajaxUpdateConfigs (config, $(this));
	});
	
	$("#reader_display_style").change (function () {
		var config = {
			"reader_display_style" : $("#reader_display_style").val ()
		};
		
		ajaxUpdateConfigs (config, $(this));
	});
	
	$("#manga_directory").focusout (function () {
		var config = {
			"manga_directory" : $("#manga_directory").val ()
		};
		
		ajaxUpdateConfigs (config, $(this));
	});
	
	$("#library_view_type").change (function () {
		var config = {
			"library_view_type" : $("#library_view_type").val ()
		};
		
		ajaxUpdateConfigs (config, $(this));
	});
	
	$("#rescan_library_btn").click (function () {
		var $btn = $(this);
		$btn.html ("LOADING");
		
		$.ajax ({
			url: "ajax/Controllers/Config/ajaxRescanLibrary",
			success: function () {
				$btn.html ("DONE!");
			}
		});
	});
});
