<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

class DisplayLibraryView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<style>
			.library_display_container .manga_series_wrap {
				margin: 10px;
				width: 300px;
				display: inline-block;
				vertical-align: top;
			}
			
			.library_display_container .manga_series_wrap .title {
				display: block;
				color: #b9b9b9;
				text-align: center;
				font-family: Arial;
			}
			
			.library_display_container .manga_series_wrap a {
				display: block;
			}
			
			.library_display_container .manga_series_wrap a img {
				width: 100%;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="library_display_container">';
			foreach ($this->getSeries () as $series) {
				$output .=
				'<div class="manga_series_wrap">
					<h2 class="title">'.$series['title'].'</h2>
					<a href="'.$series['link'].'">
						<img src="'.$series['source'].'" />
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
	 * Sets display data for each series.
	 *
	 * Uses the following array structure:
	 * array
	 *   ├── [0]
	 *   │    ├── ['link']    string  series title
	 *   │    ├── ['link']    string  href reader link for the manga series
	 *   │    └── ['source']  string  image source for the series cover
	 *   │    .
	 *   │    .
	 *   └── [n]
	 * 
	 * @param array $series display data for each series
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on:
	 *         - non-array items
	 *         - missing array item keys
	 *         - non string array items
	 *         - empty array items
	 */
	protected function setSeries (array $series) {
		foreach ($series as $item) {
			if (!is_array ($item)) {
				throw new InvalidArgumentException ('Argument (Series) items must be of type array.');
			}
			
			foreach (['title', 'link', 'source'] as $key) {
				if (!array_key_exists ($key, $item)) {
					throw new InvalidArgumentException ("Argument (Series) items must have key \"{$key}\"");
				}
				
				if (!is_string ($item[$key])) {
					throw new InvalidArgumentException ("Argument (Series) items key \"{$key}\" must be of type string.");
				}
			}
		}
		
		$this->series = $series;
	}
	
	/**
	 * Gets display data for each series.
	 * 
	 * @return array display data for each series
	 */
	private function getSeries () {
		return ($this->series);
	}
}
