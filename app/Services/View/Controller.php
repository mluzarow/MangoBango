<?php
namespace Services\View;

/**
 * Controller for the view processing service.
 */
class Controller {
	/**
	 * Builds the view processing service.
	 * 
	 * @return Service view processing service
	 * 
	 * @throws TypeError on non-Service return
	 */
	public function buildViewService () : Service {
		return new Service (
			$this->buildViewFactory (),
			$this->buildViewProvider ()
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
	 * @return Provider view provider
	 * 
	 * @throws TypeError on non-Provider return
	 */
	private function buildViewProvider () : Provider {
		return new Provider ();
	}
}
