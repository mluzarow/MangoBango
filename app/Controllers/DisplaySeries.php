<?php
declare (strict_types = 1);

namespace Controllers;

use ViewItems\PageViews\DisplaySeriesView;

/**
 * Controller managing data for view class DispaySeriesView.
 */
class DisplaySeries {
	/**
	 * Constructor for controller DisplaySeries.
	 */
	public function __construct () {
		$this->db = \Core\Database::getInstance ();
	}
	
	/**
	 * Runs page process.
	 */
	public function begin () {
		// Fetch manga directory
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = $this->db->query ($q);
		
		$manga_directory = $r[0]['config_value'];
		
		// Fetch manga info by ID
		$q = '
			SELECT `s`.`folder_name` as `series_folder`, `v`.*
			FROM `manga_directories_series` AS `s`
			JOIN `manga_directories_volumes` AS `v`
				ON `s`.`manga_id` = `v`.`manga_id`
			WHERE `s`.`manga_id` = '.$_GET['s'];
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return;
		}
		
		$view_parameters = [];
		$view_parameters['volumes'] = [];
		
		foreach ($r as $v) {
			if (empty($v['cover'])) {
				$path = '';
			} else {
				$path = "{$manga_directory}\\{$v['series_folder']}\\{$v['folder_name']}\\cover.{$v['cover']}";
			}
			
			$view_parameters['volumes'][] = [
				'link' => "/reader?s={$v['manga_id']}&v={$v['sort']}&c=1",
				'source' => $path
			];
		}
		
		$q = '
			SELECT `v`.`sort` AS `volume_sort`, `c`.`sort` AS `chapter_sort`
			FROM `manga_directories_volumes` AS `v`
			JOIN `manga_directories_chapters` AS `c`
				ON `v`.`volume_id` = `c`.`volume_id`
			WHERE `v`.`manga_id` = '.$_GET['s'];
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return;
		}
		
		$view_parameters['chapters'] = [];
		foreach ($r as $row) {
			$key = "{$row['volume_sort']}{$row['chapter_sort']}";
			
			$view_parameters['chapters'][$key] = [
				'title' => "Volume {$row['volume_sort']} Chapter {$row['chapter_sort']}",
				'link' => "\\reader?s={$_GET['s']}&v={$row['volume_sort']}&c={$row['chapter_sort']}"
			];
		}
		
		ksort ($view_parameters['chapters']);
		
		$q = '
			SELECT `name`, `summary`, `genres`
			FROM `manga_metadata`
			WHERE `manga_id` = '.$_GET['s'];
		$r = $this->db->query ($q);
		
		$view_parameters['summary'] = '';
		$view_parameters['genres'] = [];
		$view_parameters['title'] = '';
		
		if ($r !== false) {
			$row = current ($r);
			
			$view_parameters['summary'] = empty ($row['summary']) ? '' : $row['summary'];
			$view_parameters['genres'] = empty($row['genres']) ? [] : json_decode ($row['genres'], true);
			$view_parameters['title'] = empty ($row['name']) ? '' : $row['name'];
		}
		
		return (new \Services\View\Controller ())->
			buildViewService ($_SERVER['DOCUMENT_ROOT'])->
			buildView (
				[
					'name' => 'DisplaySeries',
					'CSS' => ['DisplaySeries'],
					'HTML' => 'DisplaySeries',
					'JS' => ['LazyLoader', 'LazyLoaderEvents', 'DisplaySeries']
				],
				$view_parameters
			);
	}
}
