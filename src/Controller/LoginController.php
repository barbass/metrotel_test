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
            View::render('template', [
                'content' => View::render('login', [], false),
                'error' => (!empty($error)) ? $error : false,
            ]);
        }
	}

    public function registration() {
        if (!empty($_POST)) {
            try {
                UserValidation::validateLogin((!empty($_POST['login'])) ? $_POST['login'] : null);
                UserValidation::validateName((!empty($_POST['name'])) ? $_POST['name'] : null);
                UserValidation::validateLastname((!empty($_POST['lastname'])) ? $_POST['lastname'] : null);
                UserValidation::validateEmail((!empty($_POST['email'])) ? $_POST['email'] : null);
                UserValidation::validatePassword((!empty($_POST['password'])) ? $_POST['password'] : null);

                if (UserRepository::findByEmail($_POST['email'])) {
                    throw new \InvalidArgumentException('Такой email уже есть в базе!');
                }
                if (UserRepository::findByUsername($_POST['login'])) {
                    throw new \InvalidArgumentException('Такой логин уже есть в базе!');
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

                $success = 'Вы успешно зарегистрированы!';

                $_POST = [];
            } catch(\Exception $e) {
                $error = $e->getMessage();
            }
        }

		if (Authorization::isAuth()) {
            View::redirect('default/index');
        } else {
            View::render('template', [
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
