/*
	Page JS for view DisplayLibraryView.
 */
$(window).ready (function () {
	var lazyLoader = new LazyLoader ("placeholder");
	
	lazyLoader.findPlaceholders ();
	lazyLoader.replacePlaceholders ();
});
