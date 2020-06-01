<?php

namespace Guard;

use Repository\UserRepository;

class Authorization {
    protected static $user;

    public static function isAuth(): bool
    {
        @session_start();

        if (empty($_SESSION['id'])) {
            return false;
        }

        if (empty(self::$user)) {
            self::$user = UserRepository::find((int)$_SESSION['id']);
        }

       return (!empty(self::$user)) ? true : false;
    }

    public static function login(string $username, string $password): void
    {
        $user = UserRepository::findByUsername($username);
        if (!$user) {
            throw new \Exception('User not found!');
        }

        // TODO: Check password

        $_SESSION['id'] = $user['id'];
    }

    public static function logout(): void
    {
        if (self::isAuth()) {
            @session_destroy();
        }
    }

    public static function getFullname(): string
    {
        return self::$user['name'].' '.self::$user['lastname'];
    }

    /**
	 * Сравнение паролей хэша
	 * @param string Пароль
	 * @param string Хранимый хэш пароля
	 */
	public function checkPassword(string $password, string $password_hash): bool
    {
		return password_verify($password, $password_hash);
	}

	/**
	 * Получение хэша пароля
	 */
	public function getPasswordHash(string $password): string
    {
		return password_hash($password, PASSWORD_BCRYPT, array('cost' => 14));
	}
}