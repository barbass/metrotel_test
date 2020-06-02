<?php

namespace Repository;

use Metrotel\Src\AbstractRepository;
use Metrotel\Db;

class UserRepository extends AbstractRepository {
    protected static $table = 'user';
    protected static $primary_key = 'id';

    public static function findByUsername($username) {
        Db::getInstance()->query("SELECT * FROM `".self::$table."` WHERE `login` = ?", [$username]);
        return Db::getInstance()->getRow();
    }

    public static function findByEmail($email) {
        Db::getInstance()->query("SELECT * FROM `".self::$table."` WHERE `email` = ?", [$email]);
        return Db::getInstance()->getRow();
    }
}