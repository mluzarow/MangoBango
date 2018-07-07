$(window).ready (function () {
	$(".logout_btn").click (function () {
		$(this).attr ("disabled", true);
		
		$.ajax ({
			url: "ajax/Core/SessionManager/unloadSession",
			method: "GET"
		}).done (function () {
			window.location = "/login";
		});
	});
});
