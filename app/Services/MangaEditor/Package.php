<?php
declare (strict_types = 1);

namespace Services\MangaEditor;

use Exception\UnimplementedService;
use Services\IPackage;

/**
 * Manga editor package.
 */
class Package implements IPackage {
	/**
	 * Starts a given service of the package by name.
	 * 
	 * @param string $service_name name of service to start
	 * 
	 * @return object service class
	 * 
	 * @throws TypeError on non-string parameter or non-object return
	 * @throws UnimplementedService on un-implemented service requested
	 */
	public function startService (string $service_name) : object {
		switch ($service_name) {
			case 'MangaMetadata': return $this->startMangaMetadata ();
			
			default: throw new UnimplementedService (
				get_class ($this),
				$service_name
			);
		}
	}
	
	private function startMangaMetadata () : MangaMetadataService {
		return new MangaMetadataService ();
	}
}
