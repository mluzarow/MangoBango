<?php
namespace Services\View\Data;

/**
 * View data object for the Master view.
 */
class Master implements IViewData {
	/**
	 * @var string   $title         list of image paths
	 * @var string   $username next chapter anchor link
	 * @var ViewItem $view_content  view content
	 */
	private $title;
	private $username;
	private $view_content;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param string   $title         list of image paths
	 * @param string   $username next chapter anchor link
	 * @param ViewItem $view_content  view content
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (
		string $title,
		string $username,
		ViewItem $view_content
	) {
		$this->setTitle ($title);
		$this->setUsername ($username);
		$this->setViewContent ($view_content);
	}
	
	/**
	 * Gets page title.
	 * 
	 * @return string page title
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getTitle () : string {
		return $this->title;
	}
	
	/**
	 * Gets username.
	 * 
	 * @return string username
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getUsername () : string {
		return $this->username;
	}
	
	/**
	 * Gets view content.
	 * 
	 * @return ViewItem view content
	 * 
	 * @throws TypeError on non-ViewItem return
	 */
	public function getViewContent () : ViewItem {
		return $this->view_content;
	}
	
	/**
	 * Gets the view name to which the data is tied (the controller's name).
	 * 
	 * @return string page controller name
	 * 
	 * @throws TypeError on non-string return
	 */
	public function getViewName () : string {
		return 'Master';
	}
	
	/**
	 * Sets page title.
	 * 
	 * @param string $title page title
	 * 
	 * @throws TypeError on non-string parameter
	 */
	private function setTitle (string $title) {
		$this->title = $title;
	}
	
	/**
	 * Sets username.
	 * 
	 * @param string $username username
	 * 
	 * @throws TypeError on non-string parameter
	 */
	private function setUsername (string $username) {
		$this->username = $username;
	}
	
	/**
	 * Sets view content.
	 * 
	 * @param string $view_content view content
	 * 
	 * @throws TypeError on non-ViewItem parameter
	 */
	private function setViewContent (ViewItem $view_content) {
		$this->view_content = $view_content;
	}
}
