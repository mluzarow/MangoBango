<?php
namespace Controllers;

/**
 * Page controller for setting up the server for the first time.
 */
class FirstTimeSetup {
	/**
	 * Constructor for page controller FirstTimeSetup.
	 */
	public function __construct () {
		
	}
	
	/**
	 * Creates all the necessary tables for the server.
	 */
	public function ajaxCreateDatabase () {
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
		\Core\Database::query ($q);
		
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
		\Core\Database::query ($q);
		
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
		\Core\Database::query ($q);
		
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
		\Core\Database::query ($q);
		
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
		\Core\Database::query ($q);
		
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
		\Core\Database::query ($q);
		
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
		\Core\Database::query ($q);
		
		$q = '
			CREATE TABLE `user_types` (
				`type_name` VARCHAR(255) NOT NULL,
				`permissions` VARCHAR(255) NULL DEFAULT NULL,
				PRIMARY KEY (`type_name`)
			)
			COLLATE = "utf8_general_ci"
			ENGINE = InnoDB';
		\Core\Database::query ($q);
	}
}
