<?php

namespace Controller;

use Metrotel\View;
use Metrotel\Src\AbstractController;
use Guard\Authorization;

class DefaultController extends AbstractController {

	public function index() {
        if (Authorization::isAuth()) {
            echo View::render('template');
        } else {
            View::redirect('login/index');
        }
	}
}
