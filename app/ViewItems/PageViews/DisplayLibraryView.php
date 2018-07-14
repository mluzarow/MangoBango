<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

class DisplayLibraryView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/DisplayLibrary.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="library_display_container">';
			foreach ($this->getMangaData () as $manga) {
				$output .=
				'<div class="manga_series_wrap">
					<h2 class="title">'.$manga['title'].'</h2>
					<a href="'.$manga['link'].'">
						<div class="placeholder" data-origin="'.$manga['path'].'">
							<img src="\resources\icons\placeholder.svg" />
						</div>
					</a>
				</div>';
			}
			
			if (empty ($this->getMangaData ())) {
				$output .=
				'<div class="nothing_to_show">
					No manga in your library :<
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
	 * @param array $manga_data dictionary of manga data in the following structure:
	 *  [manga ID]      int    manga ID
	 *    ├── ['link']  string link to the series page for this manga
	 *    ├── ['path']  string path to cover image
	 *    └── ['title'] string meta name of series
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on:
	 *         - missing array item keys
	 *         - non string array items
	 *         - empty array items
	 */
	protected function setMangaData (array $manga_data) {
		foreach ($manga_data as $manga) {
			foreach (['link', 'path', 'title'] as $key) {
				if (!array_key_exists ($key, $manga)) {
					throw new \InvalidArgumentException ("Argument (Manga Data) items must have key \"{$key}\"");
				}
				
				if (!is_string ($manga[$key])) {
					throw new \InvalidArgumentException ("Argument (Manga Data) item at key \"{$key}\" must be of type string.");
				}
				
				if (empty ($manga[$key])) {
					throw new \InvalidArgumentException ("Argument (Manga Data) item at key \"{$key}\" cannot be empty.");
				}
			}
		}
		
		$this->manga_data = $manga_data;
	}
	
	/**
	 * Gets display data for each series.
	 * 
	 * @return array dictionary of manga data
	 */
	private function getMangaData () {
		return ($this->manga_data);
	}
}
