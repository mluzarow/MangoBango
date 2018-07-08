<?php
namespace Controllers;

use \ViewItems\PageViews\FirstTimeSetupView;

/**
 * Page controller for setting up the server for the first time.
 */
class FirstTimeSetup {
	/**
	 * Constructor for page controller FirstTimeSetup.
	 */
	public function __construct () {
		\Core\MetaPage::setTitle ('First Time Setup');
		\Core\MetaPage::setHead ('');
		\Core\MetaPage::setBody ('');
		
		$view = new FirstTimeSetupView ([]);
		$view->render ();
	}
	
	/**
	 * Creates all the necessary tables for the server.
	 * 
	 * @return array list of status messages
	 * 
	 * @throws TypeError on non-array returned messages list
	 */
	public function ajaxCreateDatabase () : array {
		$messages = [];
		
		$q = '
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
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'manga_directories_chapters');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_directories_series` (
				`manga_id` INT(10) NOT NULL AUTO_INCREMENT,
				`path` VARCHAR(255) NOT NULL,
				`series_cover` VARCHAR(20) NULL DEFAULT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'manga_directories_series');
		
		$q = '
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
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'manga_directories_volumes');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_metadata` (
				`manga_id` INT(10) NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`name_original` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'manga_metadata');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `server_configs` (
				`config_id` INT(11) NOT NULL AUTO_INCREMENT,
				`config_name` VARCHAR(255) NOT NULL,
				`config_value` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`config_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'server_configs');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `statistics` (
				`stat_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` VARCHAR(255) NOT NULL,
				`value` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`stat_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'statistics');
		
		$q = '
			CREATE TABLE `users` (
				`user_id` INT(10) NOT NULL AUTO_INCREMENT,
				`username` VARCHAR(50) NOT NULL,
				`password` VARCHAR(255) NOT NULL,
				`type` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`user_id`),
				UNIQUE INDEX `username` (`username`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'users');
		
		$q = '
			CREATE TABLE `user_types` (
				`type_name` VARCHAR(255) NOT NULL,
				`permissions` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`type_name`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		$r = \Core\Database::query ($q);
		$messages[] = $this->createMessage ($r, 'user_types');
		
		return ($messages);
	}
	
	/**
	 * Creates a table creation message.
	 * 
	 * @param bool   $success status of table creation
	 * @param string $table   table name
	 * 
	 * @return array created message
	 * 
	 * @throws TypeError on:
	 *         - Non-bool success flag
	 *         - Non-string table name
	 *         - Non-array returned message
	 */
	private function createMessage (bool $success, string $table) : array {
		if ($success === true) {
			$code = 1;
			$msg = "Created table `{$table}`";
		} else {
			$code = 0;
			$msg = "Failed creating table `{$table}`";
		}
		
		$message = [
			'code' => $code,
			'message' => $msg
		];
		
		return ($message);
	}
}
