/*
	Page JS for view DisplayLibraryView.
 */
$(window).ready (function () {
	$(".title").each (function () {
		if ($(this).html ().length > 20) {
			let displayText = $(this).html ().substring (0, 20);
			let fullText = $(this).html ();
			
			$(this).html (displayText);
			$(this).append (
				$("<div></div>")
					.addClass ("elipsis")
					.html ("...")
			);
			$(this).append (
				$("<div></div>")
					.addClass ("title_expand")
					.html (fullText)
			);
		}
	});
});

$(window).on ("load", function () {
	var lazyLoader = new LazyLoader ("placeholder");
	
	lazyLoader.findPlaceholders ();
	lazyLoader.replacePlaceholders ();
});
