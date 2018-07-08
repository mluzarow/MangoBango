$(window).ready (function () {
	$(".setup_start_btn").click (function () {
		$.ajax ({
			url: "ajax/Controllers/FirstTimeSetup/ajaxCreateDatabases",
			method: "POST",
			data: {
				ajax: 1
			}
		}).done (function (response) {
			generateMessageList (repsonse);
		});
	});
	
	function generateMessageList (msgList) {
		alert (msgList);
	}
});