$(window).ready (function () {
	$("#login_btn").click (function () {
		$.ajax ({
			url: "ajax/Core/SessionManager/ajaxValidateLogin",
			method: "POST",
			data: {
				username: $("#username_field").val (),
				password: $("#password_field").val ()
			}
		}).done (function (response) {
			if (response === "1") {
				window.location = "/";
			} else {
				$(".login_box .warning").toggle (true);
			}
		});
	});
});
