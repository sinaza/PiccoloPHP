<?php

final class Error
{
	private static $_instance = Null;

	public function __construct()
	{
		set_error_handler([$this, 'customHandler'], E_WARNING | E_NOTICE);
		register_shutdown_function([$this, 'shutdownHandler']);

		/* From php.net: The following error types cannot be handled with a user defined function: 
		 * E_ERROR, E_PARSE, E_CORE_ERROR, E_CORE_WARNING, E_COMPILE_ERROR, E_COMPILE_WARNING, 
		 * and most of E_STRICT raised in the file where set_error_handler() is called.
		*/
	}

	public static function instance()
	{
		if(!self::$_instance)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function customHandler($no = Null, $str = Null, $file = Null, $line = Null)
	{
		foreach(func_get_args() as $arg)
			$error = date('Y-m-d H:i:s')." -- {$arg} \r\n";

		error_log($error, 3, Config::instance()->get('server','error'));

		die;
	}

	public function shutdownHandler()
	{
		# Needs to be modified to something actually useful!
		error_log(date('Y-m-d H:i:s').'Application Down!', 3, Config::instance()->get('server', 'error'));
	}
}

?>
