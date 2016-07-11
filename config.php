<?php

class Config
{
	private static $_instance = Null;

	public static function instance()
	{
		if(!self::$_instance)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function get()
	{
		$info = array_shift(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 1));

		$args = $info['args'];

		//Why bother? because now using only Config::instance()->get()
		//inside any project will read its own config file
		if(strpos($info['file'], PICCOLOAPP) !== false)
			$path = PICCOLOAPP.'/'."piccolophp_config.ini";
		else
		{
			$project = preg_replace('/_.*/','',end(explode('/',$info['file'])));
			$path = "{$project}_config.ini";
		}

		if(file_exists($path))
		{
			$config = parse_ini_file($path, true);
			return $this->getResult($config, $args);
		}
		else
			Error::instance()->customHandler(404, "{$path}: Config File Not Found"); // Manual error reporting
	}

	private function getResult($config, $args)
	{
		foreach($args as $arg)
		{
			$config = $config[$arg];
	
			if(empty($config))
				Error::instance()->customHandler(404, "{$arg}: Undefined Config Key"); // Manual error reporting
		}

		return $config;
	}
}

?>
