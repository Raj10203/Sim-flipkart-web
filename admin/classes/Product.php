<?php
namespace Admin\Classes;
require_once('../../classes/traits/ItemOperations.php');

use Admin\Classes\Traits\ItemOperations;
class Product
{
    use ItemOperations;
    protected $conn;
    protected $table = 'products';

    public function __construct(Database $db)
    {
        $this->conn = $db?->connect();
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        return $product;
    }

    public function addProduct($name, $image, $category, $price, $description)
    {
        $query = "INSERT INTO " . $this->table . " (name, image_path, category_id, price, description) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $name, $image, $category, $price, $description);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function editProduct($id, $name, $image, $category, $price, $description) 
    {
        if (!empty($image['name'])) {
            $query = "UPDATE " . $this->table . " SET name = ?, image_path = ?, category_id = ?, price = ?, description = ? WHERE id = ?";
            $imagePath = '/admin/uploads/product-images/' . basename($image['name']);
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssssss", $name, $imagePath, $category, $price, $description, $id);
        } else {
            $query = "UPDATE " . $this->table . " SET name = ?, category_id = ?, price = ?, description = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssss", $name, $category, $price, $description, $id);
        }
        $stmt->execute();
        $result = $stmt->affected_rows > 0;
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
