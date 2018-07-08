<?php
namespace DBViewer\Views;

use \ViewItems\ViewAbstract;

/**
 * Page view for table contents list.
 */
class TableView extends ViewAbstract {
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
			
			.row_list {
				margin: 10px auto 0 auto;
				width: 65%;
				background-color: #3c3c3c;
				box-shadow: 0 0 4px 4px rgba(24, 24, 24, 0.4);
				box-sizing: border-box;
			}
			
			.row_list .header {
				padding: 2px 10px;
				background-color: #626262;
				font-family: Consolas;
				font-size: 1.2em;
			}
			
			.row_list .inner_wrap {
				padding: 10px;
			}
			
			.result_table {
				padding: 5px;
				display: table;
			}
			
			.table_header {
				display: table-row;
				background-color: #c6c6c6;
			}
			
			.table_header div {
				padding: 5px;
				display: table-cell;
			}
			
			.table_row {
				display: table-row;
				background-color: #ebebeb;
			}
			
			.table_row div {
				padding: 5px;
				display: table-cell;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		'<div class="row_list">
			<div class="header">Table: '.$_GET['table_name'].'</div>
			<div class="inner_wrap">
				<div class="result_table">
					<div class="table_header">';
						foreach (array_keys (current ($table_rows)) as $key) {
							$output .= '<div>'.$key.'</div>';
						}
					$output .=
					'</div>';
						foreach ($table_rows as $row) {
							$output .=
							'<div class="table_row">
								<div>'.implode ('</div><div>', $row).'</div>
							</div>';
						}
		$output .=
				'</div>
			</div>
		</div>';
		
		return ($output);
	}
	
	/**
	 * Constructs the javascript using the available properties.
	 */
	protected function constructJavascript () {
		return ('');
	}
	
	/**
	 * Sets the table name.
	 * 
	 * @param string $table_name table name
	 * 
	 * @throws TypeError on non-string parameter
	 */
	protected function setTableName (string $table_name) {
		$this->table_name = $table_name;
	}
	
	/**
	 * Sets table row content list.
	 * 
	 * @param array $table_rows list of table rows
	 * 
	 * @throws TypeError on non-array parameter
	 */
	protected function setTableRows (array $table_rows) {
		$this->table_rows = $table_rows;
	}
	
	/**
	 * Gets table name.
	 * 
	 * @return string table name
	 */
	private function getTableName () {
		return ($this->table_name);
	}
	
	/**
	 * Gets list of table rows.
	 * 
	 * @return array list of table rows
	 */
	private function getTableRows () {
		return ($this->table_rows);
	}
}
