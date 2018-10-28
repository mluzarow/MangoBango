<?php
namespace Services\View\Data;

/**
 * View data object for the Page view.
 */
class Page implements IViewData {
	/**
	 * @var string   $title         page title
	 * @var ViewItem $view_content  view content
	 */
	private $title;
	private $view_content;
	
	/**
	 * Constructor for data object.
	 * 
	 * @param string   $title        page title
	 * @param ViewItem $view_content view content
	 * 
	 * @throws TypeError on invalid parameter type
	 */
	public function __construct (string $title, ViewItem $view_content) {
		$this->setTitle ($title);
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
		return 'Page';
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
