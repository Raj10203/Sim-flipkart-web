<?php

namespace Classes\Traits;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";

use Classes\Database;

trait ItemOperations
{
    public function deleteItem(string $tableName, string $colunName, string $value)
    {
        $query = "DELETE FROM $tableName WHERE $colunName = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $value);
        return $stmt->execute();
    }

    public function getItemById(string $tableName, int $id)
    {
        $query = "SELECT * FROM $tableName WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function getAllItems(string $tableName)
    {
        $query = "SELECT * FROM $tableName";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getTableName()
    {
        return static::$table;
    }

    public function getConnection()
    {
        if (isset($this->conn)) {
            return $this->conn;
        }
        return Database::getInstance()->getConnection();
    }
}
