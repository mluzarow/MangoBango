/*
	Events for lazy loading using LazyLoader.js
 */
function lazyLoadByScroll () {
	$(window).on ("load", () => {
		var lazyLoader = new LazyLoader ();
		
		// Request first batch of images on load once
		var scrollTimeout = true;
		
		lazyLoader.replacePlaceholders (
			lazyLoader.findPlaceholdersViewport ()
		);
		
		setTimeout (() => scrollTimeout = false, 1000);
		
		$(window).scroll (() => {
			if (scrollTimeout === false)
				scrollTimeout = true;
			
			lazyLoader.replacePlaceholders (
				lazyLoader.findPlaceholdersViewport ()
			);
			
			setTimeout (() => scrollTimeout = false, 1000);
		});
	});
}
