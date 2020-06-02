<?php

namespace Validation\Entity;

class UserValidation {
    public static function validateLogin(?string $login): string
    {
        if (empty($login)) {
            throw new \InvalidArgumentException('Логин не должен быть пустым.');
        }

        if (1 !== preg_match('/^[a-z0-9]/i', $login)) {
            throw new \InvalidArgumentException('Логин должен содержать латинские символы или цифры.');
        }

        if (mb_strlen($login) > 50) {
            throw new \InvalidArgumentException('Логин должен быть не длинее 50 символовв.');
        }

        return $login;
    }

    public static function validateName(?string $name): string
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('Имя не должно быть пустым.');
        }

        if (1 !== preg_match('/^[а-яa-z]/i', $name)) {
            throw new \InvalidArgumentException('Имя должно содержать латинские или кириллические символы.');
        }

        if (mb_strlen($name) > 50) {
            throw new \InvalidArgumentException('Имя должно быть не больше 50 символов.');
        }

        return $name;
    }

    public static function validateLastname(?string $lastname): string
    {
        if (empty($lastname)) {
            throw new \InvalidArgumentException('Фамилия не должно быть пустым.');
        }

        if (1 !== preg_match('/^[а-яa-z]/i', $lastname)) {
            throw new \InvalidArgumentException('Фамилия должна содержать латинские или кириллические символы.');
        }

        if (mb_strlen($lastname) > 50) {
            throw new \InvalidArgumentException('Фамилия должно быть не больше 50 символов.');
        }

        return $lastname;
    }

    public static function validatePassword(?string $plainPassword): string
    {
        if (empty($plainPassword)) {
            throw new \InvalidArgumentException('Пароль не должно быть пустым.');
        }

        if (mb_strlen(trim($plainPassword)) < 6) {
            throw new \InvalidArgumentException('Пароль должен быть длинее 6 символов.');
        }

        if (mb_strlen($plainPassword) > 50) {
            throw new \InvalidArgumentException('Пароль не должен быть больше 50 символов.');
        }

        if (ctype_digit($plainPassword) ||
			preg_match('/^([а-яa-z])+$/i', $plainPassword)
		) {
			throw new \InvalidArgumentException('Пароль должен содержать И буквы И числа.');
		}

        return $plainPassword;
    }

    public static function validateEmail(?string $email): string
    {
        if (empty($email)) {
            throw new \InvalidArgumentException('Email не должно быть пустым.');
        }

        if (false === mb_strpos($email, '@')) {
            throw new \InvalidArgumentException('Проверьте email на правильность (@).');
        }

        if (mb_strlen($email) > 50) {
            throw new \InvalidArgumentException('Email должен быть не больше 50 символов.');
        }

        return $email;
    }

}