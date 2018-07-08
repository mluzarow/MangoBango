<?php
namespace DBViewer\Views;

use \ViewItems\ViewAbstract;

/**
 * Database viewer dashboard view.
 */
class DashboardView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<style>
			html, body {
				margin: 0;
				padding: 0;
			}
			
			body {
				height: 100%;
				background-color: #222;
			}
			
			.main_display {
				margin: 0 auto;
				padding: 10px;
				width: 65%;
				background-color: #3c3c3c;
				box-shadow: 0 0 4px 4px rgba(24, 24, 24, 0.4);
				box-sizing: border-box;
				color: #fff;
			}
			
			.table_list {
				margin: 10px auto 0 auto;
				width: 65%;
				background-color: #3c3c3c;
				box-shadow: 0 0 4px 4px rgba(24, 24, 24, 0.4);
				box-sizing: border-box;
			}
			
			.table_list .header {
				padding: 2px 10px;
				background-color: #626262;
				font-family: Consolas;
				font-size: 1.2em;
			}
			
			.table_list .inner_wrap {
				padding: 10px;
			}
			
			.table_list .inner_wrap a {
				display: block;
				color: #4576bf;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="main_display">
			<div class="welcome">Welcome to the database dashboard.</div>
			<div class="db_details">
				You are currently connected to DB server "server".
				<br>
				Client Info: '.$this->getDetails ('client_info').'
				<br>
				Server Info: '.$this->getDetails ('server_info').'
				<br>
				Host Info: '.$this->getDetails ('host_info').'
				<br>
				Stats: '.$this->getDetails ('stat').'
			</div>
		</div>
		<div class="table_list">
			<div class="header">Tables</div>
			<div class="inner_wrap">';
				foreach ($this->getTables () as $table) {
					$output .=
					'<a href="/db/table?table_name='.$table.'">
						'.$table.'
					</a>';
				}
		$output .=
			'</div>
		<div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
	
	/**
	 * Sets database details.
	 * 
	 * @param array $details database details dictionary
	 * 
	 * @throws TypeErro on non-array parameter
	 * @throws InvalidArgumentException on missing keys and non-string items
	 */
	protected function setDetails (array $details) {
		$required_keys = [
			'client_info',
			'server_info',
			'host_info',
			'stat'
		];
		
		foreach ($required_keys as $key) {
			if (!array_key_exists ($key, $details)) {
				throw new \InvalidArgumentException ('Argument (Details) must have key "'.$key.'".');
			}
			if (!is_string ($details[$key])) {
				throw new \InvalidArgumentException ('Argument (Details) items must be strings.');
			}
		}
		
		$this->details = $details;
	}
	
	/**
	 * Sets list of database tables.
	 * 
	 * @param array $tables list of database tables
	 *
	 * @throws TypeError on non-array parameter
	 * @throws InvalidArgumentException on non-string items
	 */
	protected function setTables (array $tables) {
		foreach ($tables as $table) {
			if (!is_string ($table)) {
				throw new \InvalidArgumentException ('Argument (Tables) items must be strings.');
			}
		}
		
		$this->tables = $tables;
	}
	
	/**
	 * Gets database connection details by key.
	 * 
	 * @param string $key detail key
	 * 
	 * @return string database details of choice
	 *
	 * @throws TypeError on non-string parameter
	 */
	private function getDetails (string $key) {
		return ($this->details[$key]);
	}
	
	/**
	 * Gets database tables.
	 * 
	 * @return array list of database tables
	 */
	private function getTables () {
		return ($this->tables);
	}
}
