<?php

namespace Validation\Entity;

class UserPhonebookValidation {
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

    public static function validatePhone(?string $phone): string
    {
        if (empty($phone)) {
            throw new \InvalidArgumentException('Телефон не может быть пустым.');
        }

        if (strlen($phone) < 11 || strlen($phone) > 16) {
            throw new \InvalidArgumentException('Телефон должен быть от 11 до 16 символов.');
        }

        if (1 !== preg_match('/^[0-9]/i', $phone)) {
            throw new \InvalidArgumentException('Телефон должен содержать только цифры.');
        }

        return $phone;
    }

}