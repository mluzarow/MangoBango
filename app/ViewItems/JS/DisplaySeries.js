/*
	Page JS for view DisplaySeriesView.
 */
// Fix for height of chapter list to always reach the bottom of
// the viewport no matter what
$(window).ready (function () {
	let chapterTop = $(".chapter_container").offset ().top;
	let chapterHeight = $(".chapter_container").height ();
	let viewportHeight = $(window).height ();
	let volumeHeight = $(".library_display_container").height ();
	
	if (viewportHeight > (chapterTop + chapterHeight)) {
		$(".chapter_container").height (viewportHeight - chapterTop);
	} else if (volumeHeight > chapterHeight) {
		$(".chapter_container").height (volumeHeight);
	}
});

$(window).on ("load", function () {
	var lazyLoader = new LazyLoader ("placeholder");
	
	lazyLoader.findPlaceholders ();
	lazyLoader.replacePlaceholders ();
});
