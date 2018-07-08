$(window).ready (function () {
	$(".setup_start_btn").click (function () {
		$.ajax ({
			url: "ajax/Controllers/FirstTimeSetup/ajaxCreateDatabases",
			method: "POST",
			data: {
				ajax: 1
			}
		}).done (function (response) {
			$(".section_two").removeClass ("section_two");
		});
	});
	
	$(".add_user_btn").click (function () {
		$.ajax ({
			url: "ajax/Core/SessionManager/ajaxCreateUser",
			method: "POST",
			data: {
				username: $("#username").val (),
				password: $("#password").val ()
			}
		}).done (function (response) {
			$(".section_three").removeClass ("section_three");
			
			setTimeout (function () {
				window.location = "/login";
			}, 10000);
		});
	});
});