<?php
declare (strict_types = 1);

namespace ViewItems\Common\View;

use ViewItems\View;
use ViewItems\Common\Data\BlockContainer as ViewData;

/**
 * View for a list of block items.
 */
class BlockContainer extends View {
	/**
	 * Creates the CSS for this view.
	 * 
	 * @return string CSS for this view
	 * 
	 * @throws TypeError on non-string return
	 */
	protected function renderCSS () : string {
		$output =
		'<style title="Common\BlockContainer">
			.block_container {
				font-family: Consolas;
			}
			
			.block_container > .heading {
				margin-bottom: 0;
				text-align: center;
				font-size: 2em;
			}
			
			.block_container > .items_wrap {
				padding: 30px;
			}
		</style>';
		
		foreach ($this->getViewData ()->getBlockCollection () as $view) {
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
		'<div class="block_container">
			<h2 class="header">
				'.$this->getViewData ()->getTitle ().'
			</div>
			<div class="items_wrap">';
				foreach ($this->getViewData ()->getBlockCollection () as $view) {
					$output .= $view->getHTML ();
				}
		$output .=
			'</div>
		</div>';
		
		return $output;
	}
}
