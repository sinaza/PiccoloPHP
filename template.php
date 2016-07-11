<?php

final class Template
{
	private static $_instance = Null;

	public static function instance()
	{
		if(!self::$_instance)
			self::$_instance = new self();

		return self::$_instance;
	}

	public function render($view, $vars = false)
	{
		if($vars)
			extract($vars);

		$explode = explode('/', $view);
		$layout  = $explode[0];
		$project = $explode[1];
		$file    = $explode[2];

		$path	 =
				   Config::instance()->get('default', 'view_dir') .
				   DIRECTORY_SEPARATOR . 
				   $file; 

		$assets = $this->getAssets($project);

		$view =  $path . '.php';

		include "layouts/{$layout}.php";
	}

	protected function getAssets($project)
	{
		$server = Config::instance()->get('server', 'address') . 
				  str_replace($_SERVER['HOME'], '', ROOTPATH) . 
				  $project . DIRECTORY_SEPARATOR;

		$scripts = $this->getStatics($project, 'js');
		$styles  = $this->getStatics($project, 'css');

		$jsAssets = $this->fetchJs($scripts);
		$cssAssets = $this->fetchCss($styles);

		$assets = array_merge($jsAssets, $cssAssets);
		$assets = !empty($assets) ? $assets : false;		

		return $assets;
	}
	
	protected function getStatics($project, $switch)
	{
		$result = array();	

		$dir = $project . 
			   DIRECTORY_SEPARATOR . 
			   Config::instance()->get('statics', 'name') . 
			   DIRECTORY_SEPARATOR . 
			   Config::instance()->get('statics', $switch);

		$files = array_diff(scandir(ROOTPATH.$dir), array('.', '..'));

		foreach($files as $file)
			$result[] = Config::instance()->get('server', 'address') . 
						DIRECTORY_SEPARATOR . 
						$project . 
						DIRECTORY_SEPARATOR . 
						$dir . 
						DIRECTORY_SEPARATOR . 
						$file;

		return $result;
	}

	protected function fetchJs($files)
	{
		foreach($files as $file)
			$result[] = '<script type="application/javascript" src="'.$file.'"></script>'; 		
	
		return $result;
	}

	protected function fetchCss($files)
	{
		foreach($files as $file)
			$result[] = '<link rel="stylesheet" type="text/css" href="'.$file.'"/>'; 		
	
		return $result;
	}

}

?>
