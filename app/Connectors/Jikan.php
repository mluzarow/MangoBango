<?php
namespace Connectors;

use \Connectors\Connector;

/**
 * Connector for the Jikan Unofficial My Anime List API. Used to draw metadata
 * for manga.
 * 
 * @link https://jikan.moe/ Jikan API Documentation
 */
class Jikan extends Connector {
	/**
	 * @var string Jikan API base URL
	 */
	private $jikan_base_url = 'http://api.jikan.moe/';
	
	/**
	 * Searches for manga by MAL ID.
	 * 
	 * @param int $mal_id My Anime List manga ID
	 * 
	 * @return array results of the lookup
	 * 
	 * @throws TypeError on non-int parameter & non-array return
	 */
	public function searchByMangaID (int $mal_id) : array {
		$url = $this->jikan_base_url.'manga/'.$mal_id.'/';
		
		$result = json_decode ($this->requestGET ($url), true);
		
		return ($result);
	}
	
	/**
	 * Searches for manga by the given query string.
	 * 
	 * @param string $query search query string
	 * 
	 * @return array response from Jikan API
	 */
	public function searchByQueryString (string $query) {
		$query = trim ($query);
		
		if (empty ($query)) {
			throw new \InvalidArgumentException ('Argument (Query) of searchByQueryString() cannot be empty.');
		} else if (strlen ($query) < 2) {
			throw new \InvalidArgumentException ('Argument (Query) of searchByQueryString() must be a minimum of 3 letters.');
		}
		
		$query = urlencode ($query);
		
		$url = $this->jikan_base_url.'search/manga?q='.$query.'&page=1';
		
		$result = json_decode ($this->requestGET ($url), true);
		
		return ($result);
	}
}
