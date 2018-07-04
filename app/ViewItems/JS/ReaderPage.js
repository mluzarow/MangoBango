$(window).ready (function () {
	$(".img_wrap").click (function (e) {
		let x = e.clientX - $(this).offset ().left;
		
		let $selected = $(this).find ("img.selected_image");
		
		if (x < $(this).width () / 2) {
			// Go back
			let $prevImage = $selected.prev ("img");
			
			if ($prevImage.length > 0) {
				$selected.removeClass ("selected_image");
				$prevImage.addClass ("selected_image");
			}
		} else {
			// Go forwards
			let $nextImage = $selected.next ("img");
			
			if ($nextImage.length > 0) {
				$selected.removeClass ("selected_image");
				$nextImage.addClass ("selected_image");
			}
		}
		
		$(window).scrollTop (0);
	});
});
