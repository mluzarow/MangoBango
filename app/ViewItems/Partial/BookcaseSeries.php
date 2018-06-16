<?php
namespace ViewItems\Partial;

use Interface\PartialView;

class BookcaseSeries extends PartialView {
	
	
	public function __construct (array $view_params) {
		$this->processParameters($view_params);
		$this->constructView();
	}
	
	protected function processParameters (array $view_params) {
		$this->setBookSpineImageSources ($view_params['spines']);
	} 
	
	private function setBookSpineImageSources (array $spines) {
		foreach ($spines as $spine) {
			if (!is_string ($spine)) {
				throw new InvalidArgumentException (
					'BookcaseSeries::setBookSpineImageSources - Argument (Spines) must be a string; '.gettype ($spines).' given.'
				);
			} else if (empty(trim ($spines))) {
				throw new InvalidArgumentException (
					'BookcaseSeries::setBookSpineImageSources - Argument (Spines) must not be empty.'
				);
			}
		}
		
		$this->spines = $spines; 
	}
	
	private function getBookSpineImageSources () {
		return ($this->spines);
	}
	
	protected function constructView () {
		$this->output =
		'<div class="manga_bookcase">
			<div class="inner_wrap">
				<div class="hover_filter"></div>
				<div class="floaty_frame"></div>
				<div class="floaty_wrap">
					<span>One Piece</span>
				</div><!--';
				foreach ($this->getBookSpineImageSources() as $src) {
					$this->output .=
				'--><div class="book_spine">
						<img src="'.$src.'" />
					</div><!--';
				}
		$this->output .=
		'--></div>
		</div>';
	}
}