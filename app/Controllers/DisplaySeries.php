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
				// @TODO Should probably include a placeholder cover image.
				throw new Exception('NO COVER FOR '.$v['path']);
			}
			
			$file_path = "{$manga_directory}\\{$v['path']}\\{$v['filename']}\\cover.{$v['cover']}";
			
			$f = fopen ($file_path, 'r');
			$blob = fread ($f, filesize ($file_path));
			fclose ($f);
			
			$file_segs = explode ('.', $v['path']);
			$ext = end ($file_segs);
			
			$view_parameters['volumes'][] = [
				'link' => "/reader?s={$v['manga_id']}&v={$v['sort']}&c=1",
				'source' => "data:image/{$ext};base64,".base64_encode ($blob)
			];
		}
		
		$view = new DisplaySeriesView ($view_parameters);
		
		echo $view->render ();
	}
}
