<?php 

namespace Metrotel;

class Core {
	/**
	 * @ var Metrotel/Controller
	 */
	private $controller;
	
	public function __construct() {
		$this->controller = new Controller();
	}
	
	public function run() {
		$this->controller->run();
	}
}
