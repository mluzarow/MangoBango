<?php
declare (strict_types = 1);

namespace Services\MangaEditor;

use Core\Database;
use Exception\UnimplementedService;
use Services\IPackage;

/**
 * Manga editor package.
 */
class Package implements IPackage {
	/**
	 * Starts a given service of the package by name.
	 * 
	 * @param Database $db           database connection
	 * @param string   $service_name name of service to start
	 * 
	 * @return object service class
	 * 
	 * @throws TypeError on non-string parameter or non-object return
	 * @throws UnimplementedService on un-implemented service requested
	 */
	public function startService (Database $db, string $service_name) : object {
		switch ($service_name) {
			case 'MangaMetadata': return $this->startMangaMetadata ($db);
			
			default: throw new UnimplementedService (
				get_class ($this),
				$service_name
			);
		}
	}
	
	/**
	 * Starts the manga metadata service.
	 * 
	 * @param Database $db database connection
	 * 
	 * @return MangaMetadataService instance of manga metadata service
	 * 
	 * @throws TypeError on:
	 *         - Non-Database parameter
	 *         - Non-MangaMetadataService return
	 */
	private function startMangaMetadata (Database $db) : MangaMetadataService {
		return new MangaMetadataService ($db);
	}
}
