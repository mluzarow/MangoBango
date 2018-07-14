/*
	Page JS for view ReaderStripView.
 */
$(window).on ("load", function () {
	var lazyLoader = new LazyLoader ("placeholder");
	
	lazyLoader.findPlaceholders ();
	lazyLoader.replacePlaceholders ();
});
