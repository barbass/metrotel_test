<?php

namespace Metrotel\Src;

use Metrotel\Db;

class AbstractEntity {
    /**
     * @var string
     */
    protected $table;
    /**
     * @var string
     */
    protected $primary_key = 'id';

    protected $fields = [];

    public function insert() {
        $sql = "INSERT INTO `".$this->table."` ";
        $sql_fields = [];
        $data = [];
        foreach($this->fields as $field) {
            $sql_fields[] = "`".$field."`";
            $data[] = $this->$field;
        }
        $sql_values = array_fill(0, count($this->fields), '?');
        $sql .= " (".implode($sql_fields, ', ').") VALUES (".implode($sql_values, ', ').")";

        Db::getInstance()->query($sql, $data);
        return Db::getInstance()->getRow();
    }

    public function update() {
        $sql = "UPDATE `".$this->table."` SET ";
        $sql_fields = [];
        $data = [];
        foreach($this->fields as $field) {
            if ($field == $this->primary_key) {
                continue;
            }

            $sql_fields[] = "`".$field."` = ?";
            $data[] = $this->$field;
        }
        $sql .= " ".implode($sql_fields, ', ')." ";
        $sql .= " WHERE `".$this->primary_key."` = ? ";
        $data[] = $this->{$this->primary_key};

        Db::getInstance()->query($sql, $data);
        return Db::getInstance()->getRow();
    }
}
