<?php

namespace Validation\Entity;

class UserValidation {
    public static function validateLogin(?string $login): string
    {
        if (empty($login)) {
            throw new \InvalidArgumentException('The login can not be empty.');
        }

        if (1 !== preg_match('/^[a-z0-9]/i', $login)) {
            throw new \InvalidArgumentException('The name must contain only digit or latin characters.');
        }

        if (mb_strlen($login) > 50) {
            throw new \InvalidArgumentException('The name must contain no more than 50 characters.');
        }

        return $login;
    }

    public static function validateName(?string $name): string
    {
        if (empty($name)) {
            throw new \InvalidArgumentException('The name can not be empty.');
        }

        if (1 !== preg_match('/^[а-яa-z]/i', $name)) {
            throw new \InvalidArgumentException('The name must contain only cyrillic or latin characters.');
        }

        if (mb_strlen($name) > 50) {
            throw new \InvalidArgumentException('The name must contain no more than 50 characters.');
        }

        return $name;
    }

    public static function validatePassword(?string $plainPassword): string
    {
        if (empty($plainPassword)) {
            throw new \InvalidArgumentException('The password can not be empty.');
        }

        if (mb_strlen(trim($plainPassword)) < 6) {
            throw new \InvalidArgumentException('The password must be at least 6 characters long.');
        }

        if (mb_strlen($plainPassword) > 50) {
            throw new \InvalidArgumentException('The password must contain no more than 50 characters.');
        }

        if (ctype_digit($plainPassword) ||
			preg_match('/^([а-яa-z])+$/i', $plainPassword)
		) {
			throw new \InvalidArgumentException('The password must contain latin and digit characters.');
		}

        return $plainPassword;
    }

    public static function validateEmail(?string $email): string
    {
        if (empty($email)) {
            throw new \InvalidArgumentException('The email can not be empty.');
        }

        if (false === mb_strpos($email, '@')) {
            throw new \InvalidArgumentException('The email should look like a real email.');
        }

        if (mb_strlen($email) > 50) {
            throw new \InvalidArgumentException('The email must contain no more than 50 characters.');
        }

        return $email;
    }

    public static function validateLastname(?string $lastname): string
    {
        if (empty($lastname)) {
            throw new \InvalidArgumentException('The lastname can not be empty.');
        }

        if (1 !== preg_match('/^[а-яa-z]/i', $lastname)) {
            throw new \InvalidArgumentException('The lastname must contain only cyrillic or latin characters.');
        }

        if (mb_strlen($lastname) > 50) {
            throw new \InvalidArgumentException('The lastname must contain no more than 50 characters.');
        }

        return $lastname;
    }

}