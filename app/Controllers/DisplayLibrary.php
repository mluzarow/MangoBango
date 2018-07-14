<?php
namespace Controllers;

use ViewItems\PageViews\DisplayLibraryView;
use ViewItems\PageViews\DisplayLibraryBookcaseView;

class DisplayLibrary {
	public function __construct () {
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$manga_directory = $r[0]['config_value'];
		
		// Check for library view type
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "library_view_type"';
		$r = \Core\Database::query ($q);
		
		$library_view_type = (int) $r[0]['config_value'];
		
		if ($library_view_type === 1) {
			// Display as series of covers
			$view_parameters['manga_data'] = $this->getImagesCovers ($manga_directory);
			$view = new DisplayLibraryView ($view_parameters);
		} else if ($library_view_type === 2) {
			// Display as bookcase
			$view_parameters['manga_data'] = $this->getImagesSpines ($directory_tree);
			$view = new DisplayLibraryBookcaseView ($view_parameters);
		}
		
		$view->render ();
	}
	
	/**
	 * Collects series cover image locations.
	 * 
	 * @param string $manga_directory manga directory
	 * 
	 * @return array dictionary of series data in the following structure:
	 *  [manga ID]     int    manga ID
	 *    ├── ['link'] string link to the series page for this manga
	 *    ├── ['path'] string path to cover image
	 *    └── ['name'] string meta name of series
	 */
	private function getImagesCovers ($manga_directory) {
		$q = '
			SELECT `s`.`path`, `s`.`series_cover`, `m`.`manga_id`, `m`.`name`
			FROM `manga_directories_series` AS `s`
			JOIN `manga_metadata` AS `m`
				ON `s`.`manga_id` = `m`.`manga_id`';
		$r = \Core\Database::query ($q);
		
		if ($r === false) {
			return ([]);
		}
		
		$series_data = [];
		foreach ($r as $series) {
			if (empty ($series['series_cover'])) {
				$path = '';
			} else {
				$path = "{$manga_directory}\\{$series['path']}\\series_cover.{$series['series_cover']}";
			}
			
			$series_data[] = [
				'link' => "/displaySeries?s={$series['manga_id']}",
				'path' => $path,
				'title' => $series['name']
			];
		}
		
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
			SELECT `s`.`path`, `m`.`manga_id`, `m`.`name`
			FROM `manga_directories_series` AS `s`
			JOIN `manga_metadata` AS `m`
				ON `s`.`manga_id` = `m`.`manga_id`';
		$r = \Core\Database::query ($q);
		
		if ($r === false) {
			return ([]);
		}
		
		$manga_data = [];
		foreach ($r as $row) {
			$manga_data[$row['manga_id']] = [
				'basepath' => $row['path'],
				'link' => "/displaySeries?s={$row['manga_id']}",
				'name' => $row['name'],
				'paths' => []
			];
		}
		
		$q = '
			SELECT `sort`, `manga_id`, `filename`, `spine`
			FROM `manga_directories_volumes`';
		$r = \Core\Database::query ($q);
		
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
	
	/**
	 * Process series cover images into view-ready strings.
	 * 
	 * @param array $series_data dictionary of series covers
	 * 
	 * @return array view parameters dictionary
	 */
	private function processImagesCovers ($series_data) {
		$view_parameters = [];
		$view_parameters['series'] = [];
		
		foreach ($series_data as $id => $series) {
			$f = fopen ($series['path'], 'r');
			$blob = fread ($f, filesize ($series['path']));
			fclose ($f);
			
			$file_segs = explode ('.', $series['path']);
			$ext = end ($file_segs);
			
			$view_parameters['series'][] = [
				'title' => $series['name'],
				'link' => "/displaySeries?s={$id}",
				'source' => "data:image/{$ext};base64,".base64_encode ($blob)
			];
		}
		
		usort ($view_parameters['series'], function ($a, $b) {
			if ($a['title'] > $b['title']) {
				return (1);
			} else if ($a['title'] < $b['title']) {
				return (-1);
			} else {
				return (0);
			}
		});
		
		return ($view_parameters);
	}
	
	/**
	 * Process volume spine images into view-ready strings.
	 * 
	 * @param array  $series_data     dictionary of series spines by volume
	 * @param string $manga_directory manga directory
	 * 
	 * @return array view parameters dictionary
	 */
	private function processImagesSpines ($series_data, $manga_directory) {
		$view_parameters = [];
		$view_parameters['spines'] = [];
		$view_parameters['series_links'] = [];
		
		foreach ($series_data as $series => $volumes) {
			$view_parameters['spines'][$series] = [];
			$view_parameters['series_links'][$series] = "/displaySeries?series={$series}";
			
			foreach ($volumes as $volume => $spine) {
				$file_path = "{$manga_directory}\\{$series}\\{$volume}\\{$spine}";
				
				$f = fopen ($file_path, 'r');
				$blob = fread ($f, filesize ($file_path));
				fclose ($f);
				
				$ext = explode ('.', $spine)[1];
				
				$view_parameters['spines'][$series][] = "data:image/{$ext};base64,".base64_encode ($blob);
			}
		}
		
		return ($view_parameters);
	}
}
