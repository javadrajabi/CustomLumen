<?php

namespace App\Libraries;

class Types {
	public static function getHintType(string $type)
	{
		$typeMap = [
			'int' => 'integer',
			'float' => 'double',
			'bool' => 'boolean',
			'string' => 'string',
			'array' => 'array',
			'stdclass' => 'object',
			'arrayobject' => 'object',
			'resource' => 'resource',
			'null' => 'null',
		];
		
		return $typeMap[strtolower($type)] ?? 'unknown type';
	}
}
