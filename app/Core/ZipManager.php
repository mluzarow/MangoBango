<?php
namespace Core;

/**
 * Manages ZIP file IO.
 */
class ZipManager {
	/**
	 * Reads the files from a ZIP archive.
	 * 
	 * @param string $zip_path path to the ZIP file
	 * 
	 * @return array dictionary of filename to data blob
	 */
	public static function readFiles (string $zip_path) {
		$fs = zip_open ($zip_path);
		
		if ($fs) {
			$files = [];
			
			while ($entry = zip_read ($fs)) {
				$filename = zip_entry_name ($entry);
				
				if (zip_entry_open ($fs, $entry, 'rb')) {
					$size = zip_entry_filesize ($entry);
					$blob = zip_entry_read ($entry, $size);
					zip_entry_close ($entry);
					
					$files[$filename] = base64_encode ($blob);
				}
			}
			
			zip_close ($fs);
		} else {
			return (false);
		}
		
		return ($files);
	}
}
