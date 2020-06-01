<?php

namespace Metrotel;

class Controller {
	private $config = [];
	
	public function __construct() {
		require_once(CONFIGPATH.'/route.php');
		$this->config = (!empty($config['route'])) ? $config['route'] : [];
	}
	
	public function run(string $request) {
		$uri_list = explode('/', $request);
		print_r($uri_list);
	}
}
