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

    public function addProduct($name, $image, $category, $price, $description, $discount)
    {
        $query = "INSERT INTO " . $this->table . " (name, image_path, category_id, price, description, discount) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssd", $name, $image, $category, $price, $description, $discount);
        $result =  $stmt->execute();
        return $result;
    }

    public function editProduct($id, $name, $image, $category, $price, $description, $discount) 
    {
        if (!empty($image['name'])) {
            $query = "UPDATE " . $this->table . " SET name = ?, image_path = ?, category_id = ?, price = ?, description = ?, discount = ? WHERE id = ?";
            $imagePath = '/admin/uploads/product-images/' . basename($image['name']);
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssssssd", $name, $imagePath, $category, $price, $description ,$discount, $id);
        } else {
            $query = "UPDATE " . $this->table . " SET name = ?, category_id = ?, price = ?, description = ?, discount = ?  WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssssds", $name, $category, $price, $description, $discount, $id);
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
