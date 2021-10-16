<?php

namespace App\Libraries;

class Files {
	public static function generateFilenameAndpath(string $hash_id = null) {
		do {
			$filename = \App\Libraries\Files::generateFilename($hash_id);
			$filepath = \App\Libraries\Files::generateFilepath($filename);
		} while(!$filepath);
		
		return [$filename, $filepath];
	}
	
	public static function generateFilename(string $hash_id = null) {
		if(!$hash_id) {
			$hash_id = \App\Libraries\Strings::generateRandomCode(8);
		}
		
		$filename = \App\Libraries\Strings::generateRandomCode(16) . '-' .
			$hash_id . '-' . // 8 Character [0-9A-Z]
			\App\Libraries\Strings::generateRandomCode(6);
			
		return $filename;
	}
	
	public static function generateFilepath(string $filename) {
		preg_match_all('/([A-Z0-9]{1,1})/', $filename, $matches);
		$folders = array_slice($matches[0], 0, 3);
		
		$folder_prefix = implode(DS, $folders);
		$folder = FILES_PATH . DS . $folder_prefix;
		
		if(!self::makeDir($folder)) {
			throw new \Exception('Could not make folders');
		}
		
		$filepath = $folder . DS . $filename;
		
		if(file_exists($filepath)) {
			return false;
		}
		
		return $folder_prefix . DS . $filename;
	}
	
	public static function makeDir($dirpath, $mode=0755) {
		return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}
}
