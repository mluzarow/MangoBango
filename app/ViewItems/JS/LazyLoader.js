/**
 * Lazy image loader class. Loads images by looking for placeholder divs (.placeholder),
 * replacing the HTML content with the image requested by the data-origin attribute
 * on said placeholder div.
 */
class LazyLoader {
	/**
	 * Constructor for lazy loader controller.
	 * 
	 * @param {String} placeholder CSS class of placeholder
	 */
	constructor (placeholder) {
		this.placeholder = placeholder;
		this.$placeholders = [];
	}
	
	/**
	 * Finds all the placeholders on the page.
	 */
	findPlaceholders () {
		this.$placeholders = $("." + this.placeholder);
	}
	
	/**
	 * Request images for all placeholders on the page.
	 */
	replacePlaceholders () {
		$.each (this.$placeholders, function (index, $placeholder) {
			this.requestImage ($($placeholder));
		}.bind (this));
	}
	
	/**
	 * Requests an image from the LazyLoader controller using the data-origin
	 * attribute of the given jQuery node & replaces the given node with the
	 * received image.
	 * 
	 * @param  {Node} $placeholder jQuery node of the placeholder
	 */
	requestImage ($placeholder) {
		let filePath = $placeholder.attr ("data-origin");
		
		$.ajax({
			url: "ajax/Core/LazyLoader/ajaxRequestImage",
			method: "POST",
			data: {
				filepath: filePath
			},
			success: function ($placeholder, imageData) {
				if (imageData.length > 0) {
					let classList = $placeholder[0].classList;
					
					$placeholder
						.replaceWith ("<img>")
						.attr ("src", imageData)
						.addClass (classList)
						.removeClass (this.placeholder);
				}
			}.bind (this, $placeholder)
		});
	}
}
