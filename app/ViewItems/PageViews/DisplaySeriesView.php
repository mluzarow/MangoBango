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
		'<style>
			.library_metadata {
				width: 25%;
				min-height: 866px;
				float: left;
				background-color: #2b2b2b;
				box-shadow: 0 0 4px 4px rgba(0, 0, 0,0.6);
				color: #fff;
				font-family: Consolas;
			}
			
			.library_metadata .series_title {
				display: block;
				text-align: center;
				font-size: 2em;
			}
			
			.library_metadata .series_cover {
				text-align: center;
			}
			
			.library_metadata .series_cover img {
				width: 50%;
			}
			
			.library_metadata .section_header {
				padding-top: 20px;
				padding-left: 20px;
				display: block;
				font-size: 1.4em;
			}
			
			.library_metadata .section_block {
				padding: 10px 20px;
				display: block;
			}
			
			.library_metadata .section_block .tag_wrap {
				padding: 2px 8px;
				display: inline-block;
				background-color: #007ab3;
				border-radius: 4px;
			}
			
			.library_display_container {
				width: 75%;
				float: right;
			}
			
			.library_display_container .manga_volume_wrap {
				margin: 5px;
				padding: 10px;
				width: 300px;
				display: inline-block;
				background-color: #2b2b2b;
			}
			
			.library_display_container .manga_volume_wrap:hover {
				background-color: var(--hightlight_bg);
			}
			
			.library_display_container .manga_volume_wrap a {
				display: block;
			}
			
			.library_display_container .manga_volume_wrap a img {
				width: 100%;
				height: 425px;
				vertical-align: top;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="library_metadata">
			<div class="series_title">
				Arachnid
			</div>
			<div class="series_cover">
				<img src="'.current ($this->getVolumes ())['source'].'" />
			</div>
			<div class="section_header">Summary</div>
			<div class="section_block">
				Summary Text Summary Text Summary Text Summary Text Summary Text Summary Text
				Summary Text Summary Text Summary Text Summary Text Summary Text Summary Text
				Summary Text Summary Text Summary Text Summary Text Summary Text Summary Text
				Summary Text Summary Text Summary Text Summary Text Summary Text Summary Text
			</div>
			<div class="section_header">Tags</div>
			<div class="section_block">
				<div class="tag_wrap">
					<span>Action</span>
				</div>
				<div class="tag_wrap">
					<span>Drama</span>
				</div>
				<div class="tag_wrap">
					<span>Shounen</span>
				</div>
			</div>
		</div>
		<div class="library_display_container">';
			foreach ($this->getVolumes () as $volume) {
				$output .=
				'<div class="manga_volume_wrap">
					<a href="'.$volume['link'].'">
						<img src="'.$volume['source'].'" />
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
		return ('');
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
			}
		}
		
		$this->volumes = $volumes;
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
