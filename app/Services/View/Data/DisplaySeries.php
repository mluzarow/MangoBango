<?php
namespace Services\View\Data;

/**
 * View data object for the DisplaySeries view.
 */
class DisplaySeries implements IViewData {
	/**
	 * @var array  $chapters chapter data list
	 * @var array  $genres   list of series genres
	 * @var string $summary  series summary
	 * @var string $title    series title
	 * @var array  $volumes  display data for each volume
	 */
	private $chapters;
	private $genres;
	private $summary;
	private $title;
	private $volumes;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param array  $chapters chapter data list
	 * @param array  $genres   list of series genres
	 * @param string $summary  series summary
	 * @param string $title    series title
	 * @param array  $volumes  display data for each volume
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (
		array $chapters,
		array $genres,
		string $summary,
		string $title,
		array $volumes
	) {
		$this->setChapters ($chapters);
		$this->setGenres ($genres);
		$this->setSummary ($summary);
		$this->setTitle ($title);
		$this->setVolumes ($volumes);
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'DisplaySeries';
	}
	
	/**
	 * Gets chapter anchor data list.
	 * 
	 * @return array chapter data list
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getChapters () : array {
		return $this->chapters;
	}
	
	/**
	 * Gets list of series genres.
	 * 
	 * @return array list of series genres
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getGenres () : array {
		return $this->genres;
	}
	
	/**
	 * Gets series summary.
	 * 
	 * @return string series summary
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getSummary () : string {
		if (empty ($this->summary)) {
			return '<i>No summary available.</i>';
		} else {
			return $this->summary;
		}
	}
	
	/**
	 * Gets manga title.
	 * 
	 * @return string manga title
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getTitle () : string {
		if (empty ($this->title)) {
			return '<i>No Title</i>';
		} else {
			return $this->title;
		}
	}
	
	/**
	 * Gets display data for each volume.
	 * 
	 * @return array display data for each volume
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getVolumes () : array {
		return $this->volumes;
	}
	
	/**
	 * Sets chapter anchor data list.
	 * 
	 * Uses the following array structure:
	 * array
	 *   ├── [0]
	 *   │    ├── ['link']   string  anchor href to chapter in reader 
	 *   │    └── ['title']  string  chapter title
	 *   │    .
	 *   │    .
	 *   └── [n]
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
	private function setChapters (array $chapters) {
		foreach ($chapters as $i => &$chapter) {
			if (!is_array ($chapter)) {
				throw new \InvalidArgumentException (
					"Parameter (Chapters > {$i}) must be of type array; ".
					gettype ($chapter).' given.'
				);
			}
			
			foreach (['title', 'link'] as $key) {
				if (!array_key_exists ($key, $chapter)) {
					throw new \InvalidArgumentException (
						"Parameter (Chapters > {$i}) must have key \"{$key}\"."
					);
				}
				
				if (!is_string ($chapter[$key])) {
					throw new \InvalidArgumentException (
						"Parameter (Chapters > {$i} > {$key}) must be of type ".
						'string; '.gettype ($chapter[$key]).' given.'
					);
				}
				
				$chapter[$key] = trim ($chapter[$key]);
				
				if (empty ($chapter[$key])) {
					throw new \InvalidArgumentException (
						"Parameter (Chapters > {$i} > {$key}) cannot be empty."
					);
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
	private function setGenres (array $genres) {
		foreach ($genres as $i => $genre) {
			if (!is_string ($genre)) {
				throw new \InvalidArgumentException (
					"Parameter (Genres > {$i}) must be of type string; ".
					gettype ($genre).' given.'
				);
			}
			
			if (empty ($genre)) {
				throw new \InvalidArgumentException (
					"Parameter (Genres > {$i}) cannot be empty."
				);
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
	private function setSummary (string $summary) {
		$this->summary = $summary;
	}
	
	/**
	 * Sets manga title.
	 * 
	 * @param string $title manga title
	 * 
	 * @throws TypeError on non-string parameter
	 */
	private function setTitle (string $title) {
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
	private function setVolumes (array $volumes) {
		foreach ($volumes as $i => $volume) {
			if (!is_array ($volume)) {
				throw new InvalidArgumentException (
					"Parameter (Volumes > {$i}) must be of type array; ".
					gettype ($volume).' given.'
				);
			}
			
			foreach (['link', 'source'] as $key) {
				if (!array_key_exists ($key, $volume)) {
					throw new InvalidArgumentException (
						"Paramater (Volumes > {$i}) must have key \"{$key}\"."
					);
				}
				
				if (!is_string ($volume[$key])) {
					throw new InvalidArgumentException (
						"Paramater (Volumes > {$i} > {$key}) must be of type ".
						'string; '.gettype ($volume[$key]).' given.'
					);
				}
				
				if ($key === 'link' && empty($volume[$key])) {
					throw new \InvalidArgumentException (
						"Paramater (Volumes > {$i} > {$key}) cannot be empty."
					);
				}
			}
		}
		
		$this->volumes = $volumes;
	}
}
