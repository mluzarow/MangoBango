<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

class ReaderStripView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<style>
			.strip_wrap {
				margin: 0 auto;
				width: 1200px;
				max-width: 100%;
				background-color: #fff;
				box-shadow: 0 0 25px 20px rgba(0, 0, 0, 0.3);
			}
			
			.strip_wrap img {
				margin: 0 auto;
				max-width: 100%;
				display: block;
			}
			
			.strip_wrap .continue_btn {
				display: block;
				background-color: #d68100;
			}
			
			.strip_wrap .continue_btn:hover {
				background-color: #ffbb54;
			}
			
			.strip_wrap .continue_btn a {
				padding: 20px;
				display: block;
				color: #000;
				text-align: center;
				text-decoration: none;
				font-family: Arial;
				font-size: 2em;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="strip_wrap">';
			foreach ($this->getImageList () as $image) {
				$output .= $image;
			}
			
			if ($this->getNextChapterHtml () !== null) {
				$output .=
				'<div class="continue_btn">
					'.$this->getNextChapterHtml ().'
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
	 * Sets next chapter anchor HTML.
	 * 
	 * @param string|null $next_chapter_html next chapter anchor HTML or null if no next chapter
	 */
	protected function setNextChapterHtml (string $next_chapter_html = null) {
		if ($next_chapter_html !== null) {
			$next_chapter_html = trim ($next_chapter_html);
			
			if (empty ($next_chapter_html)) {
				throw new InvalidArgumentException ('Argument (Next Chapter HTML) can not be empty string.');
			}
		}
		
		$this->next_chapter_html = $next_chapter_html;
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
	 * Gets next chapter anchor HTML.
	 * 
	 * @return string|null next chapter anchor HTML or null if no next chapter
	 */
	protected function getNextChapterHtml () {
		return ($this->next_chapter_html);
	}
}
