<?php

namespace App\Libraries;

class DeviceDetector {
	static public function processInfo(Array $info = null, $userAgent = null) // self::getInfo()
	{
		if(!$info) {
			$info = self::getInfo($userAgent);
		}
		
		$name = [];
		$model = [];
		
		if($info['brand']) {
			$name[] = $info['brand'];
			$name[] = isset($info['model']) ? $info['model'] : null;
			$model[] = isset($info['os_info']['name']) ? $info['os_info']['name'] . (isset($info['os_info']['version']) ? ' ' . $info['os_info']['version'] : null) : null;
			$model[] = isset($info['client_info']['name']) ? $info['client_info']['name'] . (isset($info['client_info']['version']) ? ' ' . $info['client_info']['version'] : null) : null;
		}
		else if(isset($info['os_info']['name'])) {
			$name[] = isset($info['os_info']['name']) ? $info['os_info']['name'] . (isset($info['os_info']['version']) ? ' ' . $info['os_info']['version'] : null) : null;
			$model[] = isset($info['client_info']['name']) ? $info['client_info']['name'] . (isset($info['client_info']['version']) ? ' ' . $info['client_info']['version'] : null) : null;
		}
		
		return [
			'name' => implode(', ', $name),
			'model' => implode(', ', $model)
		];
	}
	
	static public function getInfo($userAgent=null)
	{
		if(!$userAgent) {
			$userAgent = self::getUserAgent();
		}
		
		\DeviceDetector\Parser\Device\DeviceParserAbstract::setVersionTruncation(\DeviceDetector\Parser\Device\DeviceParserAbstract::VERSION_TRUNCATION_NONE);
		
		$dd = new \DeviceDetector\DeviceDetector($userAgent);
		
		// OPTIONAL: If called, getBot() will only return true if a bot was detected  (speeds up detection a bit)
		$dd->discardBotInformation();
		
		// OPTIONAL: If called, bot detection will completely be skipped (bots will be detected as regular devices then)
		$dd->skipBotDetection();
		
		$dd->parse();
		
		return [
			'is_bot' => $dd->isBot(),
			'bot_info' => $dd->isBot() ? $dd->getBot() : null,
			'client_info' => $dd->getClient(),
			'os_info' => $dd->getOs(),
			'device' => $dd->getDevice(),
			'brand' => $dd->getBrandName(),
			'model' => $dd->getModel(),
		];
	}
	
	static public function isBot($userAgent=null)
	{
		if(!$userAgent) {
			$userAgent = self::getUserAgent();
		}
		
		$botParser = new \DeviceDetector\Parser\Bot();
		$botParser->setUserAgent($userAgent);
		
		// OPTIONAL: discard bot information. parse() will then return true instead of information
		$botParser->discardDetails();
		
		$result = $botParser->parse();
		
		if (!is_null($result)) {
			return true;
		}
		
		return false;
	}
	
	static public function getUserAgent()
	{
		$detect = new \Mobile_Detect();
		return $detect->getUserAgent();
	}
}
