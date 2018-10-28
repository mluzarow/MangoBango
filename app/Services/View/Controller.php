<?php
namespace Services\View;

/**
 * Controller for the view processing service.
 */
class Controller {
	/**
	 * Builds the view processing service.
	 * 
	 * @param string $root_path path to MangoBango root (index)
	 * 
	 * @return Service view processing service
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	public function buildViewService (string $root_path) : Service {
		return new Service (
			$this->buildViewFactory (),
			$this->buildViewProvider ($root_path)
		);
	}
	
	/**
	 * Builds the view item factory.
	 * 
	 * @return Factory view item factory
	 * 
	 * @throws TypeError on non-Factory return
	 */
	private function buildViewFactory () : Factory {
		return new Factory ();
	}
	
	/**
	 * Builds the view provider.
	 * 
	 * @param string $root_path path to MangoBango root (index)
	 * 
	 * @return Provider view provider
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	private function buildViewProvider (string $root_path) : Provider {
		return new Provider ($root_path);
	}
}
