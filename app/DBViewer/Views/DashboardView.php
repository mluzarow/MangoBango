<?php
namespace DBViewer\Views;

class DashboardView {
	public function __construct () {
		$details = \Core\Database::getConnectionData ();
		$results = \Core\Database::query ('show tables');
		
		$tables = [];
		foreach ($results as $result) {
			$tables[] = $result['Tables_in_server'];
		}
		
		$output =
		'<html>
		<head>
			<script type="text/javascript" src="/External/Javascript/jquery-3.3.1.js"></script>
		</head>
		<body>
			<div class="main_display">
				<div class="welcome">Welcome to the database dashboard.</div>
				<div class="db_details">
					You are currently connected to DB server "server".
					<br>
					Client Info: '.$details['client_info'].'
					<br>
					Server Info: '.$details['server_info'].'
					<br>
					Host Info: '.$details['host_info'].'
					<br>
					Stats: '.$details['stat'].'
				</div>
			</div>
			<div class="table_list">
				<div class="header">Tables</div>
				<div class="inner_wrap">';
					foreach ($tables as $table) {
						$output .= 
						'<a href="/db/table?table_name='.$table.'">
							'.$table.'
						</a>';
					}
		$output .=
				'</div>
			<div>
			<style>
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
			</style>
		</body>
		</html>';
		
		echo ($output);
	}
}
