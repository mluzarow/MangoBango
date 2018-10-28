/**
 * Lazy image loader class. Loads images by looking for placeholder divs (.placeholder),
 * replacing the HTML content with the image requested by the data-origin attribute
 * on said placeholder div.
 */
class LazyLoader {
	/**
	 * Finds all the placeholders on the page.
	 *
	 * @return {Array} list of jQuery nodes of placeholders
	 */
	findPlaceholdersAll () {
		return $(".placeholder").toArray ().filter (
			node => !$(node).hasClass ("processing") && !$(node).hasClass ("done")
		);
	}
	
	/**
	 * Finds all the placeholders that fit on the section of the page currently
	 * visible to the user.
	 * 
	 * @return {Array} List of nodes within the current viewport
	 */
	findPlaceholdersViewport () {
		let nodes = $(".placeholder").toArray ().filter (
			node => !$(node).hasClass ("processing") && !$(node).hasClass ("done")
		);
		
		if (nodes.length === 0)
			return [];
		
		let vpTop = $(window).scrollTop ();
		let vpBottom = vpTop + $(window).height ();
		
		return nodes.filter (node => {
			let eTop = $(node).offset ().top;
			let eBottom = eTop + $(node).outerHeight ();
			
			return eBottom > vpTop && eTop < vpBottom;
		});
	}
	
	/**
	 * Request images for all placeholders on the page.
	 * 
	 * @param {Array} placeholders list of placeholder nodes
	 */
	replacePlaceholders (placeholders) {
		// Mark all these nodes as being actively updated.
		$.each (placeholders, (i, v) => $(v).addClass ("processing"));
		
		// Cut the images up into batches of 5
		let chunks = [];
		let tChunk = [];
		
		for (let i = 0; i < placeholders.length; i++) {
			if (tChunk.length === 5) {
				chunks.push (tChunk);
				tChunk = [];
			}
			
			tChunk.push (placeholders[i]);
		}
		
		if (tChunk.length > 0) {
			chunks.push (tChunk);
		}
		
		$.each (chunks, (i, v) => this._requestImages (v));
	}
	
	/**
	 * Requests a batch of images from the LazyLoader controller using the
	 * data-origin attribute of the given jQuery nodes & replaces the given nodes
	 * with the received images.
	 * 
	 * @param {Array} placeholders list of jQuery nodes of placeholders
	 */
	_requestImages (placeholders) {
		var filePaths = [];
		
		$.each (placeholders, (i, $v) => filePaths.push ($($v).attr ("data-origin")));
		
		$.ajax({
			url: "ajax/Core/LazyLoader/ajaxRequestImages",
			method: "POST",
			data: {
				filepaths: JSON.stringify (filePaths)
			},
			dataType: "json",
			timeout: 10000,
			error: function (placeholders) {
				// No image was found, so add a placeholder img
				$.each (placeholders, (i, $v) => {
					$v.find ("img").attr (
						"src",
						"/resources/icons/placeholder.svg"
					);
				});
			}.bind (this, placeholders),
			success: function (placeholders, imageSrc) {
				$.each (placeholders, (i, $v) => {
					if (imageSrc[i].length < 1) {
						// No image was found, so add a placeholder img
						$($v).find ("img").attr (
							"src",
							"/resources/icons/placeholder.svg"
						);
						
						return;
					}
					
					let newNode = $("<img>")
						.attr ("src", imageSrc[i])
						.addClass ($($v)[0].classList.value)
						.removeClass ("placeholder")
						.removeClass ("processing");
					
					$v.replaceWith (newNode[0]);
				});
			}.bind (this, placeholders)
		});
	}
}
