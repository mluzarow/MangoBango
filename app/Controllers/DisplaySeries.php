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
			SELECT `ds`.`series_id`, `ds`.`folder_name`, `cv`.`volume_id`, `iv`.`cover_ext`
			FROM `directories_series` AS `ds`
			JOIN `connections_volumes` AS `cv`
				ON `ds`.`series_id` = `cv`.`series_id`
			JOIN `images_volumes` AS `iv`
				ON `cv`.`volume_id` = `iv`.`volume_id`
			WHERE `ds`.`series_id` = '.$_GET['s'];
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return;
		}
		
		$view_parameters = [];
		$view_parameters['volumes'] = [];
		
		foreach ($r as $v) {
			if (empty($v['cover_ext'])) {
				$path = '';
			} else {
				$path = "{$manga_directory}\\{$v['folder_name']}\\cover.{$v['cover_ext']}";
			}
			
			$view_parameters['volumes'][] = [
				'link' => "/reader?sid={$_GET['s']}&cid=1",
				'source' => $path
			];
		}
		
		$q = '
			SELECT `mc`.`chapter_id`, `mc`.`global_sort`
			FROM `metadata_chapters` AS `mc`
			JOIN `connections_series` AS `cs`
				ON `mc`.`chapter_id` = `cs`.`chapter_id`
			WHERE `cs`.`series_id` = '.$_GET['s'];
		$r = $this->db->query ($q);
		
		if ($r === false) {
			return;
		}
		
		$view_parameters['chapters'] = [];
		foreach ($r as $row) {
			$view_parameters['chapters'][$row['global_sort']] = [
				'title' => "Chapter {$row['global_sort']}",
				'link' => "\\reader?sid={$_GET['s']}&cid={$row['chapter_id']}"
			];
		}
		
		ksort ($view_parameters['chapters']);
		
		$q = '
			SELECT `name`, `summary`, `genres`
			FROM `metadata_series`
			WHERE `series_id` = '.$_GET['s'];
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
