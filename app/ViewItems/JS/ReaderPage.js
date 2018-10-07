$(window).ready (function () {
	$(".img_wrap").click (function (e) {
		let x = e.clientX - $(this).offset ().left;
		
		let $selected = $(this).find (".selected_image");
		
		if (x < $(this).width () / 2) {
			// Go back
			let $prevImage = $selected.prev ();
			
			if ($prevImage.length > 0) {
				$selected.removeClass ("selected_image");
				$prevImage.addClass ("selected_image");
			}
		} else {
			// Go forwards
			let $nextImage = $selected.next ();
			
			if ($nextImage.length > 0) {
				$selected.removeClass ("selected_image");
				$nextImage.addClass ("selected_image");
			} else {
				// If there is no next image BUT there is a next chapter, reload
				// page with new chapter
				let nextChapter = $(".next_chapter");
				
				if (nextChapter.length > 0) {
					window.location = nextChapter.attr ("href");
				}
			}
		}
		
		$(window).scrollTop (0);
	});
});

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
