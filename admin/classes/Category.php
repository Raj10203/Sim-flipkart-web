<?php
namespace Admin\Classes;

require_once('../../classes/traits/ItemOperations.php');
use Admin\Classes\Traits\ItemOperations;
class Category
{
    use ItemOperations;
    protected $conn;
    protected $table = 'categories';

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
        $category = $result->fetch_assoc();
        return $category;
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

    public function getTableName()
    {
        return $this->table;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
