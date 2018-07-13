<?php
namespace Core;

/**
 * Controller managing the lazy loading of images.
 */
class LazyLoader {
	/**
	 * Requests an image via AJAX with the given image path.
	 * 
	 * @param string $image_path path to the requested image file
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 */
	public function ajaxRequestImage (string $image_path) : string {
		$f = fopen ($image_path, 'r');
		
		if ($f === false) {
			// No image could be loaded
			$image_data = '';
		} else {
			$blob = fread ($f, filesize ($image_path));
			
			$file_segs = explode ('.', $image_path);
			$ext = end ($file_segs);
			
			$image_data = "data:image/{$ext};base64,".base64_encode ($blob);
		}
		
		fclose ($f);
		
		return ($image_data);
	}
	
	/**
	 * Requests a list of images via AJAX with a given list of image paths.
	 * 
	 * @param array $image_paths list of paths to the requested image files
	 * 
	 * @return array list of base 64 encoded requested image files
	 */
	public function ajaxRequestImages (array $image_paths) : string {
		$image_datas = [];
		
		foreach ($image_paths as $image_path) {
			$image_datas[] = $this->ajaxRequestImage ($image_path);
		}
		
		$image_datas = json_encode ($image_datas, true);
		
		return ($image_datas);
	}
}
