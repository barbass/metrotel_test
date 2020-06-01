<?php

namespace Controller;

use Metrotel\View;
use Metrotel\Src\AbstractController;

class DefaultController extends AbstractController {
	
	public function index() {
		echo View::render('template');
	}
}
