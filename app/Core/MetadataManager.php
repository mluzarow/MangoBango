<?php
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
	
	public function __contruct () {
		$this->jikan = new Jikan ();
		$this->manga_covers = new MangaCovers ();
	}
}
