<?php
namespace Services\View\Data;

/**
 * View data object for the DisplayLibrary view.
 */
class DisplayLibrary implements IViewData  {
	/**
	 * @var array dictionary of manga data
	 */
	private $manga_data;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param array $manga_data dictionary of manga data
	 * 
	 * @throws TypeError on non-array parameter
	 */
	public function __construct (array $manga_data) {
		$this->setMangaData ($manga_data);
	}
	
	/**
	 * Gets display data for each series.
	 * 
	 * @return array dictionary of manga data
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getMangaData () : array {
		return $this->manga_data;
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'DisplayLibrary';
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
	private function setMangaData (array $manga_data) {
		foreach ($manga_data as $i => $manga) {
			foreach (['link', 'path', 'title'] as $key) {
				if (!array_key_exists ($key, $manga)) {
					throw new \InvalidArgumentException (
						"Parameter (Manga Data > {$i}) must have key \"{$key}\"."
					);
				}
				
				if (!is_string ($manga[$key])) {
					throw new \InvalidArgumentException (
						"Parameter (Manga Data > {$i} > {$key}) must be of ".
						'type string; '.gettype ($manga[$key]).' given.'
					);
				}
				
				if ($key !== 'path' && empty ($manga[$key])) {
					throw new \InvalidArgumentException (
						"Parameter (Manga Data > {$i} > {$key}) cannot be empty."
					);
				}
			}
		}
		
		$this->manga_data = $manga_data;
	}
}
