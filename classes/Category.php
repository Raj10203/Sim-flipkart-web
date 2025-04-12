<?php

namespace Classes;

use Classes\Traits\ItemOperations;

class Category extends Database
{
    use ItemOperations;

    protected static $table = 'categories';

    public function editCategory(int $id, string $name, string $description)
    {
        $query = "UPDATE " . self::$table . " SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $name, $description, $id);
        $result = $stmt->execute();
        return $result;
    }

    public function addCategory(string $name, string $description)
    {
        $query = "INSERT INTO " . self::$table . " (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $name, $description);
        $result = $stmt->execute();
        return $result;
    }
}
