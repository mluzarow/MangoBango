<?php
namespace Core;

/**
 * Controller managing the lazy loading of images.
 */
class LazyLoader {
	/**
	 * Requests a list of images via AJAX with a given list of image paths.
	 * 
	 * @return array list of base 64 encoded requested image files
	 * 
	 * @throws TypeError on invalid return type
	 */
	public function ajaxRequestImages () : string {
		// No POST variable given (or it is empty)
		if (empty ($_POST['filepaths']))
			return json_encode ([]);
		
		$filepaths = json_decode ($_POST['filepaths'], true);
		
		// JSON was invalid
		if (empty ($filepaths))
			return json_encode ([]);
		
		$image_srcs = [];
		foreach ($filepaths as $path) {
			// No data for this item
			if (empty ($path)) {
				$image_srcs[] = '';
				continue;
			}
			
			$image_srcs[] = $this->fetchImageSrc ($path);
		}
		
		return json_encode ($image_srcs);
	}
	
	/**
	 * Fetches image source data based on image path.
	 * 
	 * @param string $path path of image
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	private function fetchImageSrc (string $path) : string {
		$image_segs = explode ('#', $path);
		
		if (count ($image_segs) > 1) {
			$image_data = $this->loadArchiveImage ($image_segs[0], $image_segs[1]);
		} else {
			$image_data = $this->loadLooseImage ($image_path);
		}
		
		return $image_data;
	}
	
	/**
	 * Loads an image from from an archive.
	 * 
	 * @param string $archive_path path to the archive
	 * @param string $image_path   path of image inside archive
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	private function loadArchiveImage (
		string $archive_path,
		string $image_path
	) : string {
		// Open the archive
		$file_list = \Core\ZipManager::readFiles ($archive_path);
		
		// No image could be loaded
		if (empty ($file_list[$image_path]))
			return '';
		
		$blob = $file_list[$image_path];
		
		$file_segs = explode ('.', $image_path);
		$ext = end ($file_segs);
		
		return "data:image/{$ext};base64,".$blob;
	}
	
	/**
	 * Loads an image file.
	 * 
	 * @param string $image_path path to image
	 * 
	 * @return string base 64 encoded requested image file or empty string if no
	 *                file could be found or loaded
	 * 
	 * @throws TypeError on invalid parameter or return type
	 */
	private function loadLooseImage (string $image_path) : string {
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
		
		return $image_data;
	}
}
