<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

class ReaderPageView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/ReaderPage.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="reader_wrap">
			<div class="img_wrap">';
				$first_image_class = 'selected_image';
				foreach ($this->getFilePaths() as $path) {
					$output .=
					'<div class="placeholder '.$first_image_class.'" data-origin="'.$path.'">
						<img src="\resources\icons\loading-3s-200px.svg" />
					</div>';
					
					$first_image_class = '';
				}
				if (!empty ($this->getNextChapterLink ())) {
					$output .=
					'<a class="next_chapter" href="'.$this->getNextChapterLink ().'" />';
				}
		$output .=
			'</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script type="text/javascript" src="/ViewItems/JS/ReaderPage.js"></script>';
		
		return ($output);
	}
	
	/**
	 * Sets list of image paths.
	 * 
	 * @param array $file_paths list of image paths
	 */
	protected function setFilePaths (array $file_paths) {
		foreach ($file_paths as $path) {
			if (!is_string ($path)) {
				throw new \InvalidArgumentException ('Argument (File Paths) items must all be strings; '.gettype ($path).' given.');
			}
			
			$path = trim ($path);
			
			if (empty ($path)) {
				throw new \InvalidArgumentException ('Argument (File Paths) items can not be empty.');
			}
		}
		
		$this->file_paths = $file_paths;
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
				throw new \InvalidArgumentException ('Argument (Next Chapter link) can not be empty string.');
			}
		}
		
		$this->next_chapter_link = $next_chapter_link;
	}
	
	/**
	 * Gets list of image paths.
	 * 
	 * @return array list of image paths
	 */
	protected function getFilePaths () {
		return ($this->file_paths);
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
