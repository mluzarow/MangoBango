$(window).ready (function () {
	console.log ('loaded');
	$(".dropdown_menu_button").click (function () {
		$(".dropdown_menu_button + .dropdown_menu").slideToggle ();
	});
});
