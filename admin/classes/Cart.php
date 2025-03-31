<?php
namespace Admin\Classes;

require_once('../../classes/traits/ItemOperations.php');
use Admin\Classes\Traits\ItemOperations;
class Cart
{
    use ItemOperations;
    protected $conn;
    protected $table = 'cart';

    public function __construct(Database $db)
    {
        $this->conn = $db?->connect();
    }

    public function addToCart($userId, $productId, $price)
    {
        $query = "SELECT id FROM " . $this->table . " WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            return [
                "status" => false,
                "message" => "Product is already in the cart.",
                "class" => "error"
            ];
        } else {
            $query = "INSERT INTO " . $this->table . " (user_id, product_id, price) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("iid", $userId, $productId, $price);

            if ($stmt->execute()) {
                return [
                    "status" => true,
                    "message" => "Product added to cart.",
                    "class" => "success"
                ];
            } else {
                return [
                    "status" => false,
                    "message" => "Error adding product to cart.",
                    "class" => "error"
                ];
            }
        }
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
