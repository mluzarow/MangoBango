<?php
namespace Core;

/**
 * Controller managing the lazy loading of images.
 */
class LazyLoader {
	/**
	 * Requests an image via AJAX with the given image path.
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 */
	public function ajaxRequestImage () : string {
		if (empty ($_POST['filepath'])) {
			return ('');
		}
		
		$image_path = $_POST['filepath'];
		
		$image_segs = explode ('#', $image_path);
		
		if (count ($image_segs) > 1) {
			$image_data = $this->loadArchiveImage ($image_segs[0], $image_segs[1]);
		} else {
			$image_data = $this->loadLooseImage ($image_path);
		}
		
		return ($image_data);
	}
	
	/**
	 * Requests a list of images via AJAX with a given list of image paths.
	 * 
	 * @return array list of base 64 encoded requested image files
	 */
	public function ajaxRequestImages () : string {
		$image_datas = json_decode ($_POST['filepaths'], true);
		
		foreach ($image_paths as $image_path) {
			$image_datas[] = $this->ajaxRequestImage ($image_path);
		}
		
		$image_datas = json_encode ($image_datas, true);
		
		return ($image_datas);
	}
	
	/**
	 * Loads an image from from an archive.
	 * 
	 * @param string $archive_path path to the archive
	 * @param string $image_path   path of image inside archive
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 */
	private function loadArchiveImage ($archive_path, $image_path) {
		// Open the archive
		$file_list = \Core\ZipManager::readFiles ($archive_path));
		
		if (empty ($file_list[$image_path])) {
			// No image could be loaded
			$image_data = '';
		} else {
			$blob = $file_list[$image_path];
			
			$file_segs = explode ('.', $image_path);
			$ext = end ($file_segs);
			
			$image_data = "data:image/{$ext};base64,".base64_encode ($blob);
		}
		
		return ($image_data);
	}
	
	/**
	 * Loads an image file.
	 * 
	 * @param string $image_path path to image
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 */
	private function loadLooseImage ($image_path) {
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
}
