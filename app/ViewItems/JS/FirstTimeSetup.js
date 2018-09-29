$(window).ready (function () {
	$(".setup_start_btn").click (function () {
		$(".section_two").removeClass ("section_two");
	});
	
	$(".add_user_btn").click (function () {
		let username = $("#username").val ();
		let password = $("#password").val ();
		
		// Validate username and password
		if (username.length < 1) {
			alert ("Username can not be blank.");
			return;
		}
		
		if (password.length < 1) {
			alert ("Password can not be blank.");
			return;
		}
		
		$.ajax ({
			url: "ajax/Controllers/FirstTimeSetup/ajaxRunSetup",
			method: "POST",
			data: {
				username : username,
				password : password
			},
			success : function () {
				$(".section_three").removeClass ("section_three");
				
				setTimeout (function () {
					window.location = "/login";
				}, 10000);
			}
		});
	});
});
