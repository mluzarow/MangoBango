<?php
namespace Common\MangaInventory\Setup;

/**
 * Provider for manga inventory setup service.
 * 
 * @see \Common\MangaInventory\Package for package
 * @see \Common\MangaInventory\Setup\Service for service
 */
class Provider {
	/**
	 * @var Database database singleton
	 */
	private $db_connection;
	
	/**
	 * Constructor for setup provider.
	 * 
	 * @param Database database singleton
	 * 
	 * @throws TypeError on invalid argument types
	 */
	public function __construct (Database $db_connection) {
		$this->setConnection ($db_connection);
	}
	
	/**
	 * Creates database table for manga chapters.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaChapters () {
		return $this->getConnection ()->query ('
			CREATE TABLE IF NOT EXISTS `manga_directories_chapters` (
				`sort` INT(10) NOT NULL AUTO_INCREMENT,
				`manga_id` INT(10) NOT NULL,
				`volume_sort` INT(10) NOT NULL,
				`filename` VARCHAR(255) NOT NULL,
				`is_archive` TINYINT(1) NOT NULL,
				PRIMARY KEY (`sort`, `manga_id`, `volume_sort`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1'
		);
	}
	
	/**
	 * Creates database table for manga meta data.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaMetadata () {
		return $this->getConnection ()->query ('
			CREATE TABLE IF NOT EXISTS `manga_metadata` (
				`manga_id` INT(10) NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`name_original` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1'
		);
	}
	
	/**
	 * Creates database table for manga series.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaSeries () {
		return $this->getConnection ()->query ('
			CREATE TABLE IF NOT EXISTS `manga_directories_series` (
				`manga_id` INT(10) NOT NULL AUTO_INCREMENT,
				`path` VARCHAR(255) NOT NULL,
				`series_cover` VARCHAR(20) NULL DEFAULT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1'
		);
	}
	
	/**
	 * Creates database table for manga volumes.
	 * 
	 * @return bool table create success status
	 */
	public function createSchemaVolumes () {
		return $this->getConnection ()->query ('
			CREATE TABLE IF NOT EXISTS `manga_directories_volumes` (
				`sort` INT(10) NOT NULL AUTO_INCREMENT,
				`manga_id` INT(10) NOT NULL,
				`filename` VARCHAR(255) NOT NULL,
				`cover` VARCHAR(20) NULL DEFAULT NULL,
				`spine` VARCHAR(20) NULL DEFAULT NULL,
				`index` VARCHAR(20) NULL DEFAULT NULL,
				PRIMARY KEY (`sort`, `manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1'
		);
	}
	
	/**
	 * Gets database singleton.
	 * 
	 * @return Database database singleton
	 * 
	 * @throws TypeError on invalid argument types
	 */
	private function getConnection () : Database {
		return $this->db_connection;
	}
	
	/**
	 * Sets database singleton.
	 * 
	 * @param Database database singleton
	 * 
	 * @throws TypeError on invalid argument types
	 */
	private function setConnection (Database $db_connection) {
		$this->db_connection = $db_connection;
	}
}
