<?php
declare (strict_types = 1);

namespace ViewItems\Common\View;

use ViewItems\View;
use ViewItems\Common\Data\Block as ViewData;

class Block extends View {
	/**
	 * Creates the CSS for this view.
	 * 
	 * @return string CSS for this view
	 * 
	 * @throws TypeError on non-string return
	 */
	protected function renderCSS () : string {
		$output =
		'<style title="Common\Block">
			.common_block {
				margin-bottom: 30px;
				background-color: #2b2b2b;
				box-shadow: 0 0 4px 4px rgba(0, 0, 0, 0.4);
				box-sizing: border-box;
				color: #828282;
			}
			
			.common_block .header {
				padding: 3px 15px;
				background-color: var(--hightlight_bg);
				color: #000;
				font-size: 1.7em;
			}
			
			.common_block .items_wrap {
				padding: 10px;
				font-size: 1.5em;
			}
		</style>';
		
		foreach ($this->getViewData ()->getViewCollection () as $view) {
			$output .= $view->getCSS ();
		}
		
		return $output;
	}
	
	/**
	 * Creates the HTML for this view.
	 * 
	 * @return string HTML for this view
	 * 
	 * @throws TypeError on non-string return
	 */
	protected function renderHTML () : string {
		$output =
		'<div class="common_block">
			<div class="header">
				'.$this->getViewData ()->getTitle ().'
			</div>
			<div class="items_wrap">';
				foreach ($this->getViewData ()->getViewCollection () as $view) {
					$output .= $view->getHTML ();
				}
		$output .=
			'</div>
		</div>';
		
		return $output;
	}
}
