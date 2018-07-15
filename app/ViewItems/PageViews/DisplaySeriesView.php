<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

/**
 * View class displaying volume covers of a given series.
 */
class DisplaySeriesView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<link rel="stylesheet" type="text/css" href="/ViewItems/CSS/DisplaySeries.css">';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="library_metadata">
			<div class="section_left">
				<div class="series_title">
					'.$this->getTitle ().'
				</div>
				<div class="series_cover">
					<img src="'.current ($this->getVolumes ())['source'].'" />
				</div>
			</div>
			<div class="section_middle">
				<div class="section_header">Summary</div>
				<div class="section_block">
					'.$this->getSummary ().'
				</div>
			</div>
			<div class="section_right">
				<div class="section_header">Tags</div>
				<div class="section_block">';
					foreach ($this->getGenres () as $genre) {
						$output .=
						'<div class="tag_wrap">
							<span>'.$genre.'</span>
						</div>';
					}
					
					if (empty ($this->getGenres ())) {
						$output .=
						'<i>No tags available</i>';
					}
		$output .=
				'</div>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="left_wrap">
			<div class="sticky_glue"></div>
			<div class="chapter_container">
				<div class="header">Chapter List</div>';
				foreach ($this->getChapters () as $chapter) {
					$output .=
					'<a href="'.$chapter['link'].'">'.$chapter['title'].'</a>';
				}
		$output .=
			'</div>
		</div>
		<div class="library_display_container">';
			foreach ($this->getVolumes () as $volume) {
				$output .=
				'<div class="manga_volume_wrap">
					<a href="'.$volume['link'].'">
						<div class="placeholder" data-origin="'.$volume['source'].'">
							<img src="\resources\icons\loading-3s-200px.svg" />
						</div>
					</a>
				</div>';
			}
		$output .=
		'</div>
		<div style="clear: both"></div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script type="text/javascript" src="/ViewItems/JS/LazyLoader.js"></script>
		<script type="text/javascript" src="/ViewItems/JS/DisplaySeries.js"></script>';
		
		return ($output);
	}
	
	/**
	 * Sets chapter anchor data list.
	 * 
	 * @param array $chapters chapter data list
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on:
	 *         - Non-array chapter data
	 *         - Missing chapter data keys (title|link)
	 *         - Non-string chapter data title or link
	 *         - Empty chapter data title or lin
	 */
	protected function setChapters (array $chapters) {
		foreach ($chapters as &$chapter) {
			if (!is_array ($chapter)) {
				throw new \InvalidArgumentException ('Argument (Chapters) items must be arrays.');
			}
			
			foreach (['title', 'link'] as $key) {
				if (!array_key_exists ($key, $chapter)) {
					throw new \InvalidArgumentException ('Argument (Chapters) items must have key "'.$key.'".');
				}
				
				if (!is_string ($chapter[$key])) {
					throw new \InvalidArgumentException ('Argument (Chapters) items must be strings.');
				}
				
				$chapter[$key] = trim ($chapter[$key]);
				
				if (empty ($chapter[$key])) {
					throw new \InvalidArgumentException ('Argument (Chapters) items cannot be empty.');
				}
				
				$this->chapters = $chapters;
			}
		}
	}
	
	/**
	 * Sets list of series genre tags.
	 * 
	 * @param array $genres list of series genres
	 * 
	 * @throws TypeError on non-string parameter
	 * @throws InvalidArgumentException on non-string or empty array items
	 */
	protected function setGenres (array $genres) {
		foreach ($genres as $genre) {
			if (!is_string ($genre)) {
				throw new \InvalidArgumentException ('Argument (Genres) items must be strings.');
			}
			
			if (empty ($genre)) {
				throw new \InvalidArgumentException ('Argument (Genres) items cannot be empty.');
			}
		}
		
		$this->genres = $genres;
	}
	
	/**
	 * Sets series summary.
	 * 
	 * @var string series summary
	 * 
	 * @throws TypeError on non-string parameter
	 */
	protected function setSummary (string $summary) {
		$this->summary = $summary;
	}
	
	/**
	 * Sets manga title.
	 * 
	 * @param string $title manga title
	 * 
	 * @throws TypeError on non-string parameter
	 */
	protected function setTitle (string $title) {
		$this->title = $title;
	}
	
	/**
	 * Sets display data for each volume.
	 *
	 * Uses the following array structure:
	 * array
	 *   ├── [0]
	 *   │    ├── ['link']    string  href reader link for the manga volume
	 *   │    └── ['source']  string  image source for the volume cover
	 *   │    .
	 *   │    .
	 *   └── [n]
	 * 
	 * @param array $volumes display data for each volume
	 * 
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on:
	 *         - non-array items
	 *         - missing array item keys
	 *         - non string array items
	 *         - empty array items
	 */
	protected function setVolumes (array $volumes) {
		foreach ($volumes as $volume) {
			if (!is_array ($volume)) {
				throw new InvalidArgumentException ('Argument (Volumes) items must be of type array.');
			}
			
			foreach (['link', 'source'] as $key) {
				if (!array_key_exists ($key, $volume)) {
					throw new InvalidArgumentException ("Argument (Volumes) items must have key \"{$key}\"");
				}
				
				if (!is_string ($volume[$key])) {
					throw new InvalidArgumentException ("Argument (Volumes) items key \"{$key}\" must be of type string.");
				}
				
				if (empty($volume[$key])) {
					throw new \InvalidArgumentException ("Argument (Volumes) items key \"{$key}\" cannot be empty.");
				}
			}
		}
		
		$this->volumes = $volumes;
	}
	
	/**
	 * Gets chapter anchor data list.
	 * 
	 * @return array chapter data list
	 */
	private function getChapters () {
		return ($this->chapters);
	}
	
	/**
	 * Gets list of series genres.
	 * 
	 * @return array list of series genres
	 */
	private function getGenres () {
		return ($this->genres);
	}
	
	/**
	 * Gets series summary.
	 * 
	 * @return string series summary
	 */
	private function getSummary () {
		if (empty ($this->summary)) {
			$summary = '<i>No summary available.</i>';
		} else {
			$summary = $this->summary;
		}
		
		return ($summary);
	}
	
	/**
	 * Gets manga title.
	 * 
	 * @return string manga title
	 */
	private function getTitle () {
		if (empty ($this->title)) {
			$title = '<i>No Title</i>';
		} else {
			$title = $this->title;
		}
		
		return ($title);
	}
	
	/**
	 * Gets display data for each volume.
	 * 
	 * @return array display data for each volume
	 */
	private function getVolumes () {
		return ($this->volumes);
	}
}
