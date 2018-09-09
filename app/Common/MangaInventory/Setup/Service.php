<?php
namespace Common\MangaInventory\Setup;

/**
 * Manga inventory setup service responsible for setting up database schema for
 * manga inventory.
 * 
 * @see \Common\MangaInventory\Package for package
 * @see \Common\MangaInventory\Setup\Provider for provider
 */
class Service {
	/**
	 * @var Provider setup provider
	 */
	private $provider;
	
	/**
	 * Constructor for setup service.
	 * 
	 * @param Provider $provider setup provider
	 * 
	 * @throws TypeError on invalid argument types
	 */
	public function __construct (Provider $provider) {
		$this->provider = $provider;
	}
	
	/**
	 * Creates the tables for all manga inventory tables.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaAll () {
		return
			$this->createSchemaChapters () &&
			$this->createSchemaMetadata () &&
			$this->createSchemaSeries () &&
			$this->createSchemaVolumes ();
	}
	
	/**
	 * Creates database table for manga chapters.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaChapters () {
		return $this->provider->createSchemaChapters ();
	}
	
	/**
	 * Creates database table for manga meta data.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaMetadata () {
		return $this->provider->createSchemaMetadata ();
	}
	
	/**
	 * Creates database table for manga series.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaSeries () {
		return $this->provider->createSchemaSeries ();
	}
	
	/**
	 * Creates database table for manga volumes.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaVolumes () {
		return $this->provider->createSchemaVolumes ();
	}
}