$(window).ready (function () {
	$(".dropdown_menu_button").click (function () {
		$(this).next (".dropdown_menu").slideToggle ();
	});
});
