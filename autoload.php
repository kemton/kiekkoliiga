<?php
function __autoload($class) {
	if (file_exists($class.'.php')) {
		require_once $class.'.php';
	} else if (file_exists('controllers/'.$class.'.php')) {
		require_once 'controllers/'.$class.'.php';
	} else if (file_exists('dao/'.$class.'.php')) {
		require_once 'dao/'.$class.'.php';
	} else if (file_exists('objects/'.$class.'.php')) {
		require_once 'objects/'.$class.'.php';
	} else if (file_exists('interfaces/'.$class.'.php')) {
		require_once 'interfaces/'.$class.'.php';
	}
}
?>