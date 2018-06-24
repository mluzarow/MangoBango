<?php
namespace ViewItems\PageViews;

use \ViewItems\ViewAbstract;

/**
 * View class for the list of server configs on the config page.
 */
class ConfigView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<style>
			.config_list_wrap .title {
				text-align: center;
				font-family: Arial;
				font-size: 2em;
			}
			
			.config_list_wrap .config_list {
				padding: 30px;
			}
			
			.config_list_wrap .config_list .config_wrap {
				padding-bottom: 20px;
				font-size: 1.5em;
			}
			
			.config_list_wrap .config_list .config_wrap select,
			.config_list_wrap .config_list .config_wrap input {
				margin-left: 15px;
				font-size: 0.9em;
			}
			
			.config_list_wrap .config_list .config_wrap input {
				width: 550px;
			}
			
			.config_list_wrap .submit_btn {
				margin-left: 20px;
				padding: 10px 30px;
				display: inline-block;
				background-color: #d68100;
				cursor: pointer;
				font-family: Arial;
				font-size: 1.5em;
			}
			
			.config_list_wrap .submit_btn:hover {
				background-color: #ffaf00;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="config_list_wrap">
			<h2 class="title">Server Settings</h2>
			<form class="config_list">
				<div class="config_wrap">
					<label>Reader Display Style</label>
					<select id="reader_display_style" autocomplete="off">
						<option value="1" '.($this->getReaderDisplayStyle () === 1 ? 'selected' : '').'>Display as single panel</option>
						<option value="2" '.($this->getReaderDisplayStyle () === 2 ? 'selected' : '').'>Display as continous strip</option>
					</select>
				</div>
				<div class="config_wrap">
					<label>Manga directory</label>
					<input id="manga_directory" value="'.$this->getMangaDirectory ().'" type="text" autocomplete="off" />
				</div>
			</form>
			<div class="submit_btn">Save</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		$output =
		'<script>
			$(window).ready (function () {
				$(".config_list_wrap .submit_btn").click (function () {
					var configs = {};
					
					configs["reader_display_style"] = $("#reader_display_style").val ();
					configs["manga_directory"] = $("#manga_directory").val ();
					
					$.ajax ({
						url: "ajax/Controllers/Config/ajaxUpdateConfigs",
						method: "POST",
						data: {
							configs: JSON.stringify (configs)
						}
					}).done (function () {
						location.reload ();
					});
				});
			});
		</script>';
		
		return ($output);
	}
	
	/**
	 * Gets the manga directory setting.
	 * 
	 * @return string manga directory setting
	 */
	protected function getMangaDirectory () {
		return ($this->manga_directory);
	}
	
	/**
	 * Gets the reader display style setting.
	 * 
	 * @return int reader display style setting
	 */
	protected function getReaderDisplayStyle () {
		return ($this->reader_display_style);
	}
	
	/**
	 * Sets the manga directory setting.
	 * 
	 * @param string $config manga directory setting
	 *
	 * @throws TypeError on non-string config value
	 * @throws InvalidArgumentException on empty config value
	 */
	protected function setMangaDirectory (string $config) {
		$config = trim ($config);
		
		if (empty ($config)) {
			throw new InvalidArgumentException ('Argument (Manga Directory) can not be empty.');
		}
		
		$this->manga_directory = $config;
	}
	
	/**
	 * Sets the reader display style setting.
	 * 
	 * @param int $config reader display style setting
	 * 
	 * @throws TypeError on non-integer config value
	 * @throws InvalidArgumentException on config value out of bounds
	 */
	protected function setReaderDisplayStyle (int $config) {
		if (!in_array($config, [1, 2])) {
			throw new \InvalidArgumentException ('Argument (Reader Display Style) value must in set [1, 2]; '.$config.' given.');
		}
		
		$this->reader_display_style = $config;
	}
}
