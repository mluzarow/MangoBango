/**
 * Lazy image loader class. Loads images by looking for placeholder divs (.placeholder),
 * replacing the HTML content with the image requested by the data-origin attribute
 * on said placeholder div.
 */
class LazyLoader {
	/**
	 * Constructor for lazy loader controller.
	 * 
	 * @param {String} placeholderClass CSS class of placeholder
	 */
	constructor (placeholderClass) {
		this.placeholderClass = placeholderClass;
		this.$placeholders = [];
	}
	
	/**
	 * Finds all the placeholders on the page.
	 */
	findPlaceholders () {
		this.$placeholders = $("." + this.placeholderClass);
	}
	
	/**
	 * Request images for all placeholders on the page.
	 */
	replacePlaceholders () {
		this.requestImages (this.$placeholders);
	}
	
	/**
	 * Requests a batch of images from the LazyLoader controller using the
	 * data-origin attribute of the given jQuery nodes & replaces the given nodes
	 * with the received images.
	 * 
	 * @param {Array} placeholders list of jQuery nodes of placeholders
	 */
	requestImages (placeholders) {
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
						
						continue;
					}
					
					let newNode = $("<img>")
						.attr ("src", imageSrc[i])
						.addClass ($($v)[0].classList.value)
						.removeClass (this.placeholderClass);
					
					$v.replaceWith (newNode[0]);
				});
			}.bind (this, placeholders)
		});
	}
}
