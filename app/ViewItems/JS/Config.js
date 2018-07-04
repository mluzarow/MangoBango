$(window).ready (function () {
	$(".config_list_wrap .submit_btn").click (function () {
		var configs = {};
		
		configs["reader_display_style"] = $("#reader_display_style").val ();
		configs["manga_directory"] = $("#manga_directory").val ();
		configs["library_view_type"] = $("#library_view_type").val ();
		
		$.ajax ({
			url: "ajax/Controllers/Config/ajaxUpdateConfigs",
			method: "POST",
			data: {
				configs: JSON.stringify (configs)
			}
		}).done (function () {
			location.reload ();
		});
	});
});
