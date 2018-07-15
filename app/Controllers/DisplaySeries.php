<?php
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
		// Fetch manga directory
		$q = '
			SELECT `config_value` FROM `server_configs`
			WHERE `config_name` = "manga_directory"';
		$r = \Core\Database::query ($q);
		
		$manga_directory = $r[0]['config_value'];
		
		// Fetch manga info by ID
		$q = '
			SELECT `s`.`path`, `v`.*
			FROM `manga_directories_series` AS `s`
			JOIN `manga_directories_volumes` AS `v`
				ON `s`.`manga_id` = `v`.`manga_id`
			WHERE `s`.`manga_id` = '.$_GET['s'];
		$r = \Core\Database::query ($q);
		
		if ($r === false) {
			return;
		}
		
		$view_parameters = [];
		$view_parameters['volumes'] = [];
		
		foreach ($r as $v) {
			if (empty($v['cover'])) {
				$path = '';
			} else {
				$path = "{$manga_directory}\\{$v['path']}\\{$v['filename']}\\cover.{$v['cover']}";
			}
			
			$view_parameters['volumes'][] = [
				'link' => "/reader?s={$v['manga_id']}&v={$v['sort']}&c=1",
				'source' => $path
			];
		}
		
		$q = '
			SELECT
				`sort` AS `chapter_sort`,
				`volume_sort`
			FROM `manga_directories_chapters`
			WHERE `manga_id` = '.$_GET['s'];
		$r = \Core\Database::query ($q);
		
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
			SELECT `name`, `summary`, `genre`
			FROM `manga_metadata`
			WHERE `manga_id` = '.$_GET['s'];
		$r = \Core\Database::query ($q);
		
		$view_parameters['summary'] = '';
		$view_parameters['genres'] = [];
		
		if ($r !== false) {
			$row = current ($r);
			
			$view_parameters['summary'] = empty ($row['summary']) ? '' : $row['summary'];
			$view_parameters['genres'] = json_decode ($row['genre']);
		}
		
		$view = new DisplaySeriesView ($view_parameters);
		$view->render ();
	}
}
