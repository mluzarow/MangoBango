<?php
namespace Services\View;

use Services\View\Data\IViewData;
use Services\View\Data\ViewItem;

/**
 * View processing service.
 */
class Service {
	/**
	 * Constructor for view processing service.
	 * 
	 * @param Factory  $factory  view item factory
	 * @param Provider $provider view provider
	 * 
	 * @throws TypeError on invalid parameter types
	 */
	public function __construct (Factory $factory, Provider $provider) {
		$this->factory = $factory;
		$this->provider = $provider;
	}
	
	/**
	 * Finalizes the page with the view content given.
	 * 
	 * @param string   $title        title of the page
	 * @param ViewItem $view_content view content object
	 * 
	 * @return string page HTML (with CSS / JS tags)
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	public function buildPage (string $title, ViewItem $view_content) : string {
		$view_data = $this->factory->buildViewData (
			'Page',
			[
				'title' => $title,
				'view_content' => $view_content
			]
		);
		
		return $this->provider->fetchHTMLFile ('Page', $view_data);
	}
	
	/**
	 * Builds the requested view.
	 * 
	 * @param array $config     dictionary of view file names to load
	 * @param array $parameters dictionary of view variables
	 * 
	 * @return ViewItem processed view structure
	 *
	 * @throws TypeError on non-array parameters or non-ViewItem return
	 */
	public function buildView (array $config, array $parameters) : ViewItem {
		// Validate types and array structure
		$this->validateConfigStructure ($config);
		
		// Validate file targets
		$this->provider->validateFiles ($config);
		
		// Build view parameters object
		$view_data = $this->factory->buildViewData ($config['name'], $parameters);
		
		// Get CSS/JS tags
		$css = [];
		if (!empty ($config['CSS']))
			$css = $this->getCSSTags ($config['CSS']);
		
		$js = [];
		if (!empty ($config['JS']))
			$js = $this->getJSTags ($config['JS']);
		
		foreach ($parameters as $param) {
			if ($param instanceof ViewItem) {
				$css = array_merge ($css, $param->getCSSTags ());
				$js = array_merge ($js, $param->getJSTags ());
			}
		}
		
		// Get & process HTML
		$html = '';
		if (!empty ($config['HTML']))
			$html = $this->provider->fetchHTMLFile ($config['HTML'], $view_data);
		
		return $this->factory->buildViewItem ($css, $html, $js);
	}
	
	/**
	 * Gets CSS tags for the requested CSS files.
	 * 
	 * @param array $css_files list of CSS file names to load
	 * 
	 * @return array list of CSS tags
	 * 
	 * @throws TypeError on invalid parameter or return types
	 */
	private function getCSSTags (array $css_files) : array {
		return array_map (
			function (string $file) : string {
				return "
					<link
						rel=\"stylesheet\"
						type=\"text/css\"
						href=\"/ViewItems/CSS/{$file}.css\"
					>";
			},
			$css_files
		);
	}
	
	/**
	 * Gets JS tags for the requested JS files.
	 * 
	 * @param array $js_files list of JS file names to load
	 * 
	 * @return array list of JS tags
	 * 
	 * @throws TypeError on invalid parameter or return types
	 */
	private function getJSTags (array $js_files) : array {
		return array_map (
			function (string $file) : string {
				return "
					<script
						type=\"text/javascript\"
						src=\"/ViewItems/JS/{$file}.js\"
					>
					</script>";
			},
			$js_files
		);
	}
	
	/**
	 * Validates view config dictionary structure and data types.
	 * 
	 * @param array $config dictionary of view file names to load
	 * 
	 * @throws InvalidArgumentException on invalid dictionary structure or types
	 * @throws TypeError on non-array parameter
	 */
	private function validateConfigStructure (array $config) {
		foreach (['name', 'CSS', 'HTML', 'JS'] as $req_key)
			if (!array_key_exists ($req_key, $config))
				throw new \InvalidArgumentException (
					"Parameter (Config > {$req_key}) must exist."
				);
		
		foreach (['CSS', 'JS'] as $key) {
			if (!is_array ($config[$key]))
				throw new \InvalidArgumentException (
					"Parameter (Config > {$key}) must be of type 
					array; ".gettype ($key).' given.'
				);
			
			foreach ($config[$key] as $i => $item) {
				if (!is_string ($item))
					throw new \InvalidArgumentException (
						"Parameter (Config > {$key} > {$i}) must be of type 
						string; ".gettype ($item).' given.'
					);
				
				if (empty ($item))
					throw new \InvalidArgumentException (
						"Parameter (Config > {$key} > {$i}) must not be empty 
						if included."
					);
			}
		}
		
		foreach (['name', 'HTML'] as $key)
			if (!is_string ($config[$key]))
				throw new \InvalidArgumentException (
					"Parameter (Config > {$key}) must be of type string; ".
					gettype ($config[$key]).' given.'
				);
		
		if (empty ($config['name']))
			throw new \InvalidArgumentException (
				'Parameter (Config > name) must not be empty.'
			);
	}
}
