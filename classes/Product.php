<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/traits/ItemOperations.php";

use Classes\Traits\ItemOperations;

class Product
{
    use ItemOperations;
    protected static $table = 'products';
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function addProduct(string $name, string $image_path, int $category, float $price, string $description, float $discount)
    {
        $query = "INSERT INTO " . self::$table . " (name, image_path, category_id, price, description, discount) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssidsd", $name, $image_path, $category, $price, $description, $discount);
        $result =  $stmt->execute();
        return $result;
    }

    public function editProduct(int $id, string $name, array $image, int $category, float $price, string $description, float $discount)
    {
        if (!empty($image['name'])) {
            $query = "UPDATE " . self::$table . " SET name = ?, image_path = ?, category_id = ?, price = ?, description = ?, discount = ? WHERE id = ?";
            $imagePath = '/admin/uploads/product-images/' . basename($image['name']);
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssiisdi", $name, $imagePath, $category, $price, $description, $discount, $id);
        } else {
            $query = "UPDATE " . self::$table . " SET name = ?, category_id = ?, price = ?, description = ?, discount = ?  WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sidsdi", $name, $category, $price, $description, $discount, $id);
        }
        return $stmt->execute();;
    }
}
