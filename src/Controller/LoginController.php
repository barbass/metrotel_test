<?php

namespace Controller;

use Metrotel\View;
use Guard\Authorization;
use Validation\Entity\UserValidation;
use Repository\UserRepository;
use Entity\UserEntity;

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

                if (UserRepository::findByEmail($_POST['email'])) {
                    throw new \InvalidArgumentException('This email already exists in the database');
                }
                if (UserRepository::findByUsername($_POST['login'])) {
                    throw new \InvalidArgumentException('This login already exists in the database');
                }

                $password = Authorization::getPasswordHash($_POST['password']);

                $user = new UserEntity();
                $user->setCreatedAt(date('Y-m-d H:i:s'));
                $user->setUpdatedAt(date('Y-m-d H:i:s'));
                $user->setEmail($_POST['email']);
                $user->setLogin($_POST['login']);
                $user->setPassword($password);
                $user->setName($_POST['name']);
                $user->setLastname($_POST['lastname']);
                $user->insert();

                $success = 'You have successfully registered!';

                $_POST = [];
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
                'success' => (!empty($success)) ? $success : false,
            ]);
        }
    }

    public function logout() {
        Authorization::logout();
        View::redirect('login/index');
    }
}
