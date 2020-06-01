<?php

namespace Controller;

use Metrotel\View;
use Guard\Authorization;
use Validation\Entity\UserValidation;

class LoginController {

	public function index() {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            try {
                Authorization::login($_POST['username'], $_POST['password']);
            } catch(\Exception $e) {
                $error = $e->getMessage();
            }
        }

		if (Authorization::isAuth()) {
            View::redirect('default/index');
        } else {
            echo View::render('template', [
                'content' => View::render('login', [], false),
                'error' => (!empty($error)) ? $error : false,
            ]);
        }
	}

    public function registration() {
        if (!empty($_POST)) {
            try {
                UserValidation::validateLogin($_POST['login']);
                UserValidation::validateName($_POST['name']);
                UserValidation::validateLastname($_POST['lastname']);
                UserValidation::validateEmail($_POST['email']);
                UserValidation::validatePassword($_POST['password']);
            } catch(\Exception $e) {
                $error = $e->getMessage();
            }
        }

		if (Authorization::isAuth()) {
            View::redirect('default/index');
        } else {
            echo View::render('template', [
                'content' => View::render('registration', ['form' => $_POST], false),
                'error' => (!empty($error)) ? $error : false,
            ]);
        }
    }

    public function logout() {
        Authorization::logout();
        View::redirect('login/index');
    }
}
