<?php

namespace Repository;

use Metrotel\Src\AbstractRepository;
use Metrotel\Db;

class UserPhonebookRepository extends AbstractRepository {
    protected static $table = 'user_phonebook';
    protected static $primary_key = 'id';

    public static function findAllByUserId($id, array $filter = [], array $order = []) {
        $sql = "SELECT * FROM `".self::$table."` WHERE `user_id` = ?";
        $data = [(int)$id];

        if ($filter) {
            $sql .= " AND ";
            $sql_filter = [];
            foreach($filter as $field => $value) {
                $sql_filter[] = " `$field` = ? ";
                $data[] = $value;
            }

            $sql .= implode($sql_filter, " AND ");
        }

        if ($order) {
            $sql .= " ORDER BY ";
            $sql_order = [];
            foreach($order as $order => $by) {
                $sql_order[] = " `$order` ".$by;
            }

            $sql .= implode($sql_order, ', ');
        }

        Db::getInstance()->query($sql, $data);
        return Db::getInstance()->getRows();
    }

    public static function findByIdAndUserId($id, $user_id) {
        Db::getInstance()->query("SELECT * FROM `".self::$table."` WHERE `id` = ? AND `user_id` = ?", [(int)$id, (int)$user_id]);
        return Db::getInstance()->getRow();
    }
}