<?php

namespace Metrotel;

class Controller {
	private $config = [];
	
	public function __construct() {
		require_once(CONFIGPATH.'/route.php');
		$this->config = (!empty($config['route'])) ? $config['route'] : [];
	}
	
	public function run() {
		$uri = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$uri_list =  explode('/', $uri['path']);
		
		$host = $uri['scheme'].'://'.$uri['host'].((!empty($uri['port'])) ? ':'.$uri['port']: '');
		
		$path_list = [];

		foreach($uri_list as $uri_part) {
			if (trim($this->config['host'], '/') != trim($host, '/')) {
				$host .= $uri_part.'/';
			} elseif (!empty($uri_part)) {
				$path_list[] = $uri_part;
			}
		}
		
		
		$method = ($path_list) ? array_pop($path_list) : $this->config['default_method'];
		
		$controller_path = SRCPATH.'/';
		if ($path_list) {
			$class = array_pop($path_list);
			$class = ucfirst($class);
			$class .= 'Controller';
			
			$path_list_ucfirst = array_map(function($value) {
				return ucfirst($value);
			}, $path_list);

			$controller = implode($path_list_ucfirst, '\\').$class;
		} else {
			$controller = $this->config['default_controller'];
		}

		require_once($controller_path.'\\Controller\\'.$controller.'.php');
		$controller_class = "src\\Controller\\".$controller;
		$controller_obj = new $controller_class;
		
		if (!method_exists($controller_obj, $method)) {
			echo '404';
		} else {
			$controller_obj->{$method}();
		}
	}
}
