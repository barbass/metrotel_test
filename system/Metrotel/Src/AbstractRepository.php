<?php

namespace Metrotel\Src;

use Metrotel\Db;

class AbstractRepository {
    /**
     * @var string
     */
    protected static $table;

    /**
     * @var string
     */
    protected static $primary_key;

    public static function find($id): ?array
    {
        Db::getInstance()->query("SELECT * FROM `".static::$table."` WHERE `".static::$primary_key."` = ?", [$id]);
        return Db::getInstance()->getRow();
    }

    public static function delete($id): void
    {
        Db::getInstance()->query("DELETE FROM `".static::$table."` WHERE `".static::$primary_key."` = ?", [$id]);
    }
}
