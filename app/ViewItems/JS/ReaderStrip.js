/*
	Page JS for view ReaderStripView.
 */
$(window).on ("load", function () {
	var lazyLoader = new LazyLoader ();
	
	// Request first batch of images on load once
	var scrollTimeout = true;
	
	lazyLoader.replacePlaceholders (
		lazyLoader.findPlaceholdersViewport ()
	);
	
	setTimeout (() => scrollTimeout = false, 1000);
	
	$(window).scroll (function () {
		if (scrollTimeout === false)
			scrollTimeout = true;
		
		lazyLoader.replacePlaceholders (
			lazyLoader.findPlaceholdersViewport ()
		);
		
		setTimeout (() => scrollTimeout = false, 1000);
	});
});
