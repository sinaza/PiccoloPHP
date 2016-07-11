<?php

final class Router
{
	private static $_default;
	private static $_instance = Null;

	public function __construct()
	{
		self::$_default = Config::instance()->get('default', 'action');
	}

	public static function instance()
	{
		if(!self::$_instance)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function route()
	{
		$address	= str_replace($_SERVER['SCRIPT_NAME'].'/', '', $_SERVER['REQUEST_URI']);
		$explode	= explode('/',$address);
		$class		= $explode[0];
		$action		= !empty($explode[1]) ? $explode[1] : self::$_default;

		$controllerName	= ucfirst($class).'_Controller';
		$controller		= new $controllerName();

		// Prioritise $_POST for getting parameters
		$params			= isset($_GET['params']) ? $_GET['params'] : array();
		$params			= isset($_POST['params']) ? $_POST['params'] : $params;

		if(method_exists($controller, $action))
			call_user_func_array(array($controller,$action), $params);
		else
			Error::instance()->customHandler(404, "Please define the specified action in {$controllerName} or change the requested one");
	}
}

?>
