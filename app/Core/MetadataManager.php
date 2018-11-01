<?php
declare (strict_types = 1);

namespace Core;

use \Connectors\Jikan;
use \Connectors\MangaCovers;

/**
 * Controller for managing external and local manga metadata.
 */
class MetadataManager {
	/**
	 * @var Jikan       instance of the Jikan connector
	 * @var MangaCovers instance of the MangaCovers connector
	 */
	private $jikan;
	private $manga_covers;
	
	/**
	 * Constructor for controller MetadataManager.
	 */
	public function __construct () {
		$this->jikan = new Jikan ();
		$this->manga_covers = new MangaCovers ();
	}
	
	/**
	 * Fetches manga info by the given query string.
	 * 
	 * @param string $manga_name name of the manga to look for
	 * 
	 * @return array fetched manga information
	 * 
	 * @throws TypeError on non-string parameter & non-array return
	 */
	public function fetchMangaInfo (string $manga_name) : array {
		$manga_result = $this->jikan->searchByQueryString ($manga_name);
		
		if (empty($manga_result['result'])) {
			return ([]);
		}
		
		$manga_info = $this->jikan->searchByMangaID (
			(int) $manga_result['result'][0]['mal_id']
		);
		
		if (empty($manga_info)) {
			return ([]);
		}
		
		$final_info = [
			'title' => $manga_info['title'],
			'title_original' => $manga_info['title_japanese'],
			'summary' => $manga_info['synopsis'],
			'genres' => []
		];
		
		foreach ($manga_info['genre'] as $genre) {
			$final_info['genres'][] = $genre['name'];
		}
		
		return ($final_info);
	}
}
