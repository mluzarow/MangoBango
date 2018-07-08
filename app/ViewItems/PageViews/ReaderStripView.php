<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

class ReaderStripView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/ReaderStrip.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="strip_wrap">';
			foreach ($this->getImageList () as $image) {
				$output .=
				'<img src="'.$image.'" />';
			}
			
			if ($this->getNextChapterLink () !== null) {
				$output .=
				'<div class="continue_btn">
					<a href="'.$this->getNextChapterLink ().'">
						Continue to next chaper.
					</a>
				</div>';
			}
		$output .=
		'</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
	
	/**
	 * Sets list of image elements.
	 * 
	 * @param array $image_list list of image elements
	 */
	protected function setImageList (array $image_list) {
		foreach ($image_list as $image) {
			if (!is_string ($image)) {
				throw new InvalidArgumentException ('Argument (Image List) items must all be strings; '.gettype ($image).' given.');
			}
			
			$image = trim ($image);
			
			if (empty ($image)) {
				throw new InvalidArgumentException ('Argument (Image List) items can not be empty.');
			}
		}
		
		$this->image_list = $image_list;
	}
	
	/**
	 * Sets next chapter anchor link.
	 * 
	 * @param string|null $next_chapter_link next chapter anchor link or null if no next chapter
	 */
	protected function setNextChapterLink (string $next_chapter_link = null) {
		if ($next_chapter_link !== null) {
			$next_chapter_link = trim ($next_chapter_link);
			
			if (empty ($next_chapter_link)) {
				throw new InvalidArgumentException ('Argument (Next Chapter Link) can not be empty string.');
			}
		}
		
		$this->next_chapter_link = $next_chapter_link;
	}
	
	/**
	 * Gets list of image elements.
	 * 
	 * @return array list of image elements
	 */
	protected function getImageList () {
		return ($this->image_list);
	}
	
	/**
	 * Gets next chapter anchor link.
	 * 
	 * @return string|null next chapter anchor link or null if no next chapter
	 */
	protected function getNextChapterLink () {
		return ($this->next_chapter_link);
	}
}
