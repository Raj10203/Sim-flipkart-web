<?php

namespace Admin\Classes;
class Category
{

    protected $conn;
    protected $table = 'category';

    public function __construct(Database $db)
    {
        $this->conn = $db?->connect();
    }

    public function getCategoryById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        return $user;
    }

    public function editCategory($id, $name, $description)
    {
        $query = "UPDATE " . $this->table . " SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssi", $name, $description, $id); // 's' for strings, 'i' for integer
        $result = $stmt->execute();
        return $result;
    }

    public function addCategory($name, $description)
    {
        $query = "INSERT INTO " . $this->table . " (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $name, $description);
        $result = $stmt->execute();
        return $result;
    }
}
?>