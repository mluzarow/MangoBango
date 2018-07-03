<?php
namespace Connectors;

use \Connectors\Connector;

/**
 * Connector for the manga covers database API. Used to draw cover, spine, index,
 * and other volume images for each manga.
 * 
 * @link https://mcd.iosphe.re/#api MCD API Documentation
 */
class MangaCovers extends Connector {
	/**
	 * @var string MCD API base URL
	 */
	private $base_url = 'https://mcd.iosphe.re/api/v1/';
	
	/**
	 * Search for manga metadata using the manga series name.
	 * 
	 * @param string $title series name string
	 * 
	 * @return array manga series metadata
	 */
	public function searchByTitle ($title) {
		$url = $this->base_url.'search/';
		
		$args = [
			'Title' => urlencode ($title)
		];
		
		$result = json_decode ($this->requestPOST ($url, $args), true);
	}
}
