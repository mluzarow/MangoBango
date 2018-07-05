$(window).ready (function () {
	$("#login_btn").click (function () {
		let login = {
			'username' : $("#username_field").val (),
			'password' : $("#password_field").val ()
		};
		
		$(".login_box .warning").toggle (true);
	});
});
