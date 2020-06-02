<?php

namespace Metrotel\Src;

use Metrotel\View;
use Metrotel\Db;

class AbstractController {
	/**
	 * @var Metrotel/Db 
	 */
	protected $db;
	
	/**
	 * @var Metrotel/View 
	 */
	protected $view;
	
	public function __construct(Db $db, View $view) {
		$this->db = $db;
		$this->view = $view;
	}
}
