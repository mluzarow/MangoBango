<?php
declare (strict_types = 1);

namespace Controllers;

use \Core\Database;
use \ViewItems\PageViews\FirstTimeSetupView;

/**
 * Page controller for setting up the server for the first time.
 */
class FirstTimeSetup {
	/**
	 * AJAX method for first time database setup.
	 * 
	 * @return string JSON en coded status messages & codes
	 * 
	 * @throws TypeError on non-string return
	 */
	public function ajaxRunSetup () : string {
		if (empty($_POST['username']) || empty($_POST['password'])) {
			return json_encode ([
				'code' => 0,
				'message' => 'Invalid user data sent.'
			]);
		}
		
		$db = Database::getInstance ();
		
		$messages = [];
		
		$messages['database'] = $this->createDatabases ($db);
		$messages['config'] = $this->createDefaultConfigs ($db);
		$messages['user'] = $this->createAdminUser (
			$db,
			$_POST['username'],
			$_POST['password']
		);
		
		return json_encode ($messages);
	}
	
	/**
	 * Runs page process.
	 */
	public function begin () {
		return (new \Services\View\Controller ())->
			buildViewService ($_SERVER['DOCUMENT_ROOT'])->
			buildView (
				[
					'name' => '',
					'CSS' => ['FirstTimeSetup'],
					'HTML' => 'FirstTimeSetup',
					'JS' => ['FirstTimeSetup']
				],
				[]
			);
	}
	
	/**
	 * Creates an admin user with the given credentials.
	 * 
	 * @param Database $db database connection
	 * 
	 * @return array creation status message
	 * 
	 * @throws TypeError on incorrectly typed parameters or return
	 */
	private function createAdminUser (Database $db, string $username, string $password) : array {
		$sm = new \Core\SessionManager ();
		$status = $sm->createUser ($username, $password, 'admin');
		
		return [
			'code' => $status ? 1 : 0,
			'message' => ($status ? 'Successfully' : 'Failed').' making admin user.'
		];
	}
	
	/**
	 * Creates all the necessary tables for the server.
	 * 
	 * @return array list of status messages
	 * 
	 * @throws TypeError on incorrectly typed parameter or return
	 */
	private function createDatabases (Database $db) : array {
		$messages = [];
		
		$q = 'CREATE DATABASE `server`';
		$r = $db->query ($q);
		
		if ($r === false) {
			// Error creating database
			$messages[] = [
				$code => 0,
				$msg => 'Failed creating database `server`.'
			];
			
			return $messages;
		}
		
		$q = 'use `server`';
		$r = $db->query ($q);
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_directories_series` (
				`manga_id` INT(10) NOT NULL AUTO_INCREMENT,
				`folder_name` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_directories_series');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_directories_chapters` (
				`chapter_id` INT(10) NOT NULL AUTO_INCREMENT,
				`folder_name` VARCHAR(255) NOT NULL,
				`is_archive` TINYINT(1) NOT NULL,
				PRIMARY KEY (`chapter_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_directories_chapters');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_metadata_series` (
				`manga_id` INT(10) NOT NULL,
				`name` text NOT NULL,
				`name_original` text NULL DEFAULT NULL,
				`summary` text NULL DEFAULT NULL,
				`genres` text NULL DEFAULT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_metadata_series');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_metadata_volumes` (
				`volume_id` INT(10) NOT NULL,
				`sort` INT(10) NOT NULL,
				`volume_name` text NULL DEFAULT NULL,
				PRIMARY KEY (`volume_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_metadata_volumes');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_metadata_chapters` (
				`chapter_id` INT(10) NOT NULL,
				`sort` INT(10) NOT NULL,
				`volume_id` INT(10) NULL DEFAULT NULL,
				`chapter_name` text NULL DEFAULT NULL,
				PRIMARY KEY (`chapter_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_metadata_chapters');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_images_series` (
				`manga_id` INT(10) NOT NULL,
				`cover_ext` VARCHAR(10) NULL DEFAULT NULL,
				PRIMARY KEY (`manga_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_images_series');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `manga_images_volumes` (
				`volume_id` INT(10) NOT NULL,
				`cover_ext` VARCHAR(10) NULL DEFAULT NULL,
				`index_ext` VARCHAR(10) NULL DEFAULT NULL,
				`spine_ext` VARCHAR(10) NULL DEFAULT NULL,
				PRIMARY KEY (`volume_id`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'manga_images_volumes');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `server_configs` (
				`config_id` INT(11) NOT NULL AUTO_INCREMENT,
				`config_name` VARCHAR(255) NOT NULL,
				`config_value` VARCHAR(255) NOT NULL,
				PRIMARY KEY (`config_id`),
				UNIQUE INDEX `config_name` (`config_name`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB
			AUTO_INCREMENT = 1';
		$r = $db->query ($q);
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
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'statistics');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `users` (
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
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'users');
		
		$q = '
			CREATE TABLE IF NOT EXISTS `user_types` (
				`type_name` VARCHAR(255) NOT NULL,
				`permissions` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`type_name`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		$r = $db->query ($q);
		$messages[] = $this->createMessage ($r, 'user_types');
		
		return ($messages);
	}
	
	/**
	 * Creates default config settings.
	 * 
	 * @param Database $db database connection
	 * 
	 * @return array config creation status message
	 * 
	 * @throws TypeError on incorrectly typed parameter or return
	 */
	private function createDefaultConfigs (Database $db) : array {
		$q = '
			INSERT INTO `server_configs`
				(`config_name`, `config_value`)
			VALUES
				("reader_display_style", 2),
				("manga_directory", ""),
				("library_view_type", 1)';
		$r = $db->query ($q);
		
		return [
			'code' => $r ? 1 : 0,
			'message' => ($r ? 'Successfully' : 'Failed').' creating default configs.'
		];
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
