<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/traits/ItemOperations.php";

use Classes\Traits\ItemOperations;

class Category 
{
    use ItemOperations;
    protected static $table = 'categories';
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

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
