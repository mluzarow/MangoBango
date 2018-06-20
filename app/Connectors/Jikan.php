<?php
namespace Connectors;

/**
 * Connector for the Jikan Unofficial My Anime List API. Used to draw metadata
 * for manga.
 * 
 * @link https://jikan.moe/ Jikan API Documentation
 */
class Jikan {
	/**
	 * @var string Jikan API base URL
	 */
	private $jikan_base_url = 'http://api.jikan.me/';
	
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
			throw new \InvalidArgumentException ('Argument (Query) of Jikan::searchByQueryString cannot be empty.');
		} else if (count ($query) < 2) {
			throw new \InvalidArgumentException ('Argument (Query) of Jikan::searchByQueryString must be a minimum of 3 letters.');
		}
		
		$query = urldecode ($query);
		
		$url = $this->jikan_base_url.'search/manga/'.$query.'/1';
		
		$result = json_decode ($this->request ($url), true);
		
		return ($result);
	}
	
	/**
	 * Performs a cURL request with the constructed URL.
	 * 
	 * @param string $url constructed URL to be used with Jikan
	 * 
	 * @return string JSON response from the Jikan servers
	 */
	private function request ($url) {
		$curl = curl_init ();
		
		curl_setopt ($curl, CURLOPT_URL, $url);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
		
		$response = curl_exec ($curl);
		
		curl_close ($curl);
		
		return ($response);
	}
}
