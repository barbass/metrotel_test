<?php

namespace Metrotel;

use Metrotel\Db;
use Metrotel\View;
use Metrotel\Config;

class Controller {
	private $config = [];

	public function __construct() {
		require_once(CONFIGPATH.'/route.php');
		$this->config = (!empty($config['route'])) ? $config['route'] : [];

        Config::set('route', $config['route']);
	}

	public function run() {
		$uri = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
		$uri_list =  explode('/', $uri['path']);

		$host = $uri['scheme'].'://'.$uri['host'].((!empty($uri['port'])) ? ':'.$uri['port']: '');

		$path_list = [];

		foreach($uri_list as $uri_part) {
			if (trim($this->config['base_url'], '/') != trim($host, '/')) {
				$host .= $uri_part.'/';
			} elseif (!empty($uri_part)) {
				$path_list[] = $uri_part;
			}
		}

		$method = ($path_list) ? array_pop($path_list) : $this->config['default_method'];

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

        $db = Db::getInstance();
        $view = View::getInstance();

		$controller_class = 'Controller\\'.$controller;
		$controller_obj = new $controller_class($db, $view);

		if (!method_exists($controller_obj, $method)) {
			echo '404';
			exit(1);
		} else {
			$controller_obj->{$method}($db, $view);
		}
	}
}
