<?php

spl_autoload_register(function($class) {
	$class = strtolower($class);
	$dir = strtolower(preg_replace('/_.*/','',$class));
	$path = $class.'.php';
	
	if($class !== $dir)
	{
		$path = $dir . '/' . $path;

		if(!file_exists($path))
			Error::instance()->customHandler(404,"{$path} does not exist");
	}

	include_once($path);
});

?>
