<?php
declare (strict_types = 1);

namespace Controllers;

use ViewItems\PageViews\DisplayLibraryView;
use ViewItems\PageViews\DisplayLibraryBookcaseView;

class DisplayLibrary {
	public function __construct () {
		$this->db = \Core\Database::getInstance ();
	}
	
	/**
	 * Runs page process.
	 */
	public function begin () {
		// Get library configs
		$q = '
			SELECT `config_name`, `config_value`
			FROM `server_configs`
			WHERE `config_name` IN ("manga_directory", "library_view_type")';
		$r = $this->db->query ($q);
		
		$configs = [];
		foreach ($r as $row) {
			$configs[$row['config_name']] = $row['config_value'];
		}
		
		$configs['library_view_type'] = (int) $configs['library_view_type'];
		
		if ($configs['library_view_type'] === 1) {
			// Display as series of covers
			$view_parameters['manga_data'] = $this->getImagesCovers (
				$configs['manga_directory']
			);
			
			return (new \Services\View\Controller ())->
				buildViewService ($_SERVER['DOCUMENT_ROOT'])->
				buildView (
					[
						'name' => 'DisplayLibrary',
						'CSS' => ['DisplayLibrary'],
						'HTML' => 'DisplayLibrary',
						'JS' => ['LazyLoader', 'LazyLoaderEvents', 'DisplayLibrary']
					],
					$view_parameters
				);
		} else if ($configs['library_view_type'] === 2) {
			// Display as bookcase
			$view_parameters['manga_data'] = $this->getImagesSpines ($directory_tree);
			$view = new DisplayLibraryBookcaseView ($view_parameters);
		}
	}
	
	/**
	 * Collects series cover image locations.
	 * 
	 * @param string $manga_directory manga directory
	 * 
	 * @return array dictionary of series data in the following structure:
	 *  [manga ID]            int    manga ID
	 *    ├── ['link']        string link to the series page for this manga
	 *    ├── ['folder_name'] string path to cover image
	 *    └── ['title']       string meta name of series
	 */
	private function getImagesCovers ($manga_directory) {
		$q = '
			SELECT `m`.`series_id`, `m`.`name`, `d`.`folder_name`, `i`.`cover_ext` 
			FROM `metadata_series` AS `m`
			JOIN `directories_series` AS `d`
				ON `m`.`series_id` = `d`.`series_id`
			JOIN `images_series` AS `i`
				ON `m`.`series_id` = `i`.`series_id`';
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return ([]);
		}
		
		$series_data = [];
		foreach ($r as $series) {
			if (empty ($series['cover_ext'])) {
				$path = '';
			} else {
				$path = "{$manga_directory}\\{$series['folder_name']}\\series_cover.{$series['cover_ext']}";
			}
			
			$series_data[$series['name']] = [
				'link' => "/displaySeries?s={$series['series_id']}",
				'path' => $path,
				'title' => $series['name']
			];
		}
		
		ksort ($series_data);
		
		return ($series_data);
	}
	
	/**
	 * Collects volume spine image locations.
	 * 
	 * @param string $manga_directory manga directory
	 * 
	 * @return array dictionary of series data in the following structure:
	 *  [manga ID]         int    manga ID
	 *    ├── ['basepath'] string path to this manga's folder
	 *    ├── ['link']     string link to the series page for this manga
	 *    ├── ['name']     string meta name of series
	 *    └── ['paths']    array  list of spine paths keyed by volume sort order
	 *         ├── [0]     string path to this volume's spine image (if exists)
	 *         |    .
	 *         └── [n]
	 */
	private function getImagesSpines ($manga_directory) {
		$q = '
			SELECT `s`.`folder_name`, `m`.`manga_id`, `m`.`name`
			FROM `manga_directories_series` AS `s`
			JOIN `manga_metadata` AS `m`
				ON `s`.`manga_id` = `m`.`manga_id`';
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return ([]);
		}
		
		$manga_data = [];
		foreach ($r as $row) {
			$manga_data[$row['manga_id']] = [
				'basepath' => $row['folder_name'],
				'link' => "/displaySeries?s={$row['manga_id']}",
				'name' => $row['name'],
				'paths' => []
			];
		}
		
		$q = '
			SELECT `sort`, `manga_id`, `folder_name`, `spine`
			FROM `manga_directories_volumes`';
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return ([]);
		}
		
		foreach ($r as $row) {
			if (empty ($manga_data[$row['manga_id']])) {
				continue;
			}
			
			if (empty ($row['spine'])) {
				$manga_data[$row['manga_id']]['paths'][$row['sort']] = '';
			} else {
				$manga_data[$row['manga_id']]['paths'][$row['sort']] =
					$manga_directory.'\\'.
					$manga_data[$row['manga_id']]['basepath'].'\\'.
					$row['filename'].'\\'.
					'spine.'.$row['spine'];
			}
		}
		
		return ($manga_data);
	}
}
