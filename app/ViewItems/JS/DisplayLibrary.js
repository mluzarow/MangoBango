/*
	Page JS for view DisplayLibraryView.
 */
$(window).on ("load", function () {
	var lazyLoader = new LazyLoader ("placeholder");
	
	lazyLoader.findPlaceholders ();
	lazyLoader.replacePlaceholders ();
});
