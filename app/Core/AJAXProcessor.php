<?php
namespace Core;

/**
 * Processes AJAX requests and fires the appropriate methods.
 */
class AJAXProcessor {
	/**
	 * @var array list of URL segments from the request
	 */
	private $url_segments;
	
	/**
	 * Constructor for controller AJAXProcessor.
	 * 
	 * @param array $segments list of URL segments from the request
	 * 
	 * @throws TypeError on non-array URL segments
	 */
	public function __construct (array $segments) {
		$this->setURLSegments ($segments);
	}
	
	/**
	 * Constructs the class and method call with the path given by the segments.
	 */
	public function fireTargetMethod () {
		// Construct the method call.
		$namespace = '\\';
		for ($i = 0; $i < (count ($this->getURLSegments ()) - 1); $i++) {
			$namespace .= $this->getURLSegments ()[$i] . '\\';
		}
		$namespace = rtrim ($namespace, '\\');
		
		$method = $this->getURLSegments ()[$i];
		
		(new $namespace)->$method ();
	}
	
	/**
	 * Getter for URL segments.
	 * 
	 * @return array list of URL segments from the request
	 */
	private function getURLSegments () {
		return ($this->url_segments);
	}
	
	/**
	 * Setting for URL segments.
	 * 
	 * @param array $segments list of URL segments from the request
	 * 
	 * @throws TypeError on non-array URL segments
	 */
	private function setURLSegments (array $segments) {
		$this->url_segments = $segments;
	}
}
