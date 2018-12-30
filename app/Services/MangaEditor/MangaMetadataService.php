<?php
declare (strict_types = 1);

namespace Services\MangaEditor;

use Core\Database;
use ViewItems\Common\View\BlockContainer;

class MangaMetadataService {
	public function __construct (Database $db) {
		$this->db = $db;
	}
	
	public function buildEditor (int $series_id) : BlockContainer {
		$q = "
			SELECT `name`, `summary`, `genres`
			FROM `metadata_series`
			WHERE `series_id` = {$series_id}";
		$r = $this->db->query ($q);
		
		$row = current ($r);
		
		$summary = empty ($row['summary']) ? '' : $row['summary'];
		$genres = empty ($row['genres']) ? [] : json_decode ($row['genres'], true);
		$title = empty ($row['name']) ? '' : $row['name'];
		
		
	}
}
