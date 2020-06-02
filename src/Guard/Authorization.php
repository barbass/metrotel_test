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
            throw new \Exception('Пользователь не найден!');
        }

        if (!self::checkPassword($password, $user['password'])) {
            throw new \Exception('Пользователь не найден!');
        }

        // Warning: Можно добавить проверку на количество неудачных попыток

        @session_start();
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

    public static function getId(): int
    {
        return (int)self::$user['id'];
    }

    /**
	 * Сравнение паролей хэша
	 * @param string Пароль
	 * @param string Хранимый хэш пароля
	 */
	public static function checkPassword(string $password, string $password_hash): bool
    {
		return password_verify($password, $password_hash);
	}

	/**
	 * Получение хэша пароля
	 */
	public static function getPasswordHash(string $password): string
    {
		return password_hash($password, PASSWORD_BCRYPT, array('cost' => 14));
	}
}