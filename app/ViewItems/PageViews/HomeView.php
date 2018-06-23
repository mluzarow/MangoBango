<?php
namespace ViewItems\PageViews;

use ViewItems\ViewAbstract;

class HomeView extends ViewAbstract {
	/**
	 * Constructs the CSS using the available properties.
	 */
	protected function constructCSS () {
		$output =
		'<style>
			.home_header {
				margin: 0.5em 0;
				padding-bottom: 0.5em;
				color: #c19356;
				text-align: center;
				font-family: Consolas;
				font-size: 2em;
			}
			
			.home_header::after {
				position: relative;
				top: 16px;
				margin: 0 auto;
				width: 500px;
				display: block;
				border-bottom: 1px solid #d68100;
				content: "";
			}
			
			.statbox_grid_display {
				padding: 50px;
				display: grid;
				grid-column-gap: 50px;
				grid-row-gap: 50px;
				grid-template-columns: auto auto auto;
				box-sizing: border-box;
			}
			
			.statbox_grid_display .statbox_wrap {
				padding: 10px;
				background-color: #aaa78c;
				box-shadow: 0 0 9px 4px rgba(0, 0, 0,0.2);
				box-sizing: border-box;
				font-family: Consolas;
			}
			
			.statbox_grid_display .statbox_wrap .title {
				padding-bottom: 10px;
				display: block;
				text-align: center;
				font-size: 2em;
			}
			
			.statbox_grid_display .statbox_wrap .statbox_inner_wrap span {
				display: block;
				text-align: center;
				font-size: 3em;
			}
		</style>';
		
		return ($output);
	}
	
	/**
	 * Constructs the HTML using the available properties.
	 */
	protected function constructHTML () {
		$output =
		
		'<h2 class="home_header">Library Statistics</h2>
		<div class="statbox_grid_display">
			<div class="statbox_wrap">
				<div class="title">Number of series</div>
				<div class="statbox_inner_wrap">
					<span>6666</span>
				</div>
			</div>
			<div class="statbox_wrap">
				<div class="title">Number of series</div>
				<div class="statbox_inner_wrap">
					<span>6666</span>
				</div>
			</div>
			<div class="statbox_wrap">
				<div class="title">Number of series</div>
				<div class="statbox_inner_wrap">
					<span>6666</span>
				</div>
			</div>
			<div class="statbox_wrap">
				<div class="title">Number of series</div>
				<div class="statbox_inner_wrap">
					<span>6666</span>
				</div>
			</div>
			<div class="statbox_wrap">
				<div class="title">Number of series</div>
				<div class="statbox_inner_wrap">
					<span>6666</span>
				</div>
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
}
