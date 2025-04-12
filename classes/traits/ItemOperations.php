<?php

namespace Classes\Traits;

trait ItemOperations
{
    public function deleteItem(string $tableName, string $colunName, string $value)
    {
        $query = "DELETE FROM " . $tableName . " WHERE $colunName = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $value);
        $result =  $stmt->execute();
        return $result;
    }

    public function getItemById(string $tableName, int $id)
    {
        $query = "SELECT * FROM " . $tableName . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_assoc();
        return $items;
    }
    public function getAllItems(string $tableName)
    {
        $query = "SELECT * FROM " . $tableName;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        return $items;
    }

    public static function getTableName()
    {
        return static::$table;
    }
}
