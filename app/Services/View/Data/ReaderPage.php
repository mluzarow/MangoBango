<?php
namespace Services\View\Data;

/**
 * View data object for the ReaderPage view.
 */
class ReaderPage implements IViewData {
	/**
	 * @var array  $file_paths        list of image paths
	 * @var string $next_chapter_link next chapter anchor link
	 */
	private $file_paths;
	private $next_chapter_link;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param array  $file_paths        list of image paths
	 * @param string $next_chapter_link next chapter anchor link
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (array $file_paths, string $next_chapter_link) {
		$this->setFilePaths ($file_paths);
		$this->setNextChapterLink ($next_chapter_link);
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'ReaderPage';
	}
	
	/**
	 * Gets list of image paths.
	 * 
	 * @return array list of image paths
	 * 
	 * @throws TypeError on non-array return
	 */
	public function getFilePaths () : array {
		return $this->file_paths;
	}
	
	/**
	 * Gets next chapter anchor link.
	 * 
	 * @return string next chapter anchor link or empty if no next chapter
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getNextChapterLink () : string {
		return $this->next_chapter_link;
	}
	
	/**
	 * Sets list of image paths.
	 * 
	 * @param array $file_paths list of image paths
	 * 
	 * @throws InvalidArgumentException on non-string or empty items
	 * @throws TypeError on non-array parameter
	 */
	private function setFilePaths (array $file_paths) {
		foreach ($file_paths as $i => $path) {
			if (!is_string ($path)) {
				throw new \InvalidArgumentException (
					"Parameter (File Paths > {$i}) must be of type string; ".
					gettype ($path).' given.'
				);
			}
			
			if (empty (trim ($path))) {
				throw new \InvalidArgumentException (
					"Parameter (File Paths > {$i}) can not be empty."
				);
			}
		}
		
		$this->file_paths = $file_paths;
	}
	
	/**
	 * Sets next chapter anchor link.
	 * 
	 * @param string $next_chapter_link next chapter anchor link or empty if no
	 *                                  next chapter
	 * 
	 * @throws TypeError on non-string parameter
	 */
	private function setNextChapterLink (string $next_chapter_link) {
		$this->next_chapter_link = $next_chapter_link;
	}
}
