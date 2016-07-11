<?php

define('PICCOLOAPP', 'PiccoloPHP');
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('PICCOLOPATH', ROOTPATH.PICCOLOAPP.DIRECTORY_SEPARATOR);

require_once(PICCOLOPATH.'autoload.php');

Router::instance()->route();

?>
