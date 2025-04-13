<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/traits/ItemOperations.php";

use Classes\Traits\ItemOperations;

class Cart
{
    use ItemOperations;
    protected static $table = 'cart';
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function addToCart(int $userId, int $productId)
    {
        $query = "SELECT id FROM " . self::$table . " WHERE user_id = ? AND product_id = ?";
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
            $query = "INSERT INTO " . self::$table . " (user_id, product_id) VALUES (?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ii", $userId, $productId);

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

    public function gettAllCartByUserId(int $userId)
    {
        $query = "SELECT c.id as id, c.quantity as quantity, p.id as productId, p.name, p.price, p.image_path, p.discount FROM " . self::$table . " c JOIN " . Product::getTableName() . " p on c.product_id = p.id  WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartsByUserId = $result->fetch_all(MYSQLI_ASSOC);
        return $cartsByUserId;
    }

    public function changeQuanityById(int $id, int $change)
    {
        $query = "UPDATE " . self::$table . " c SET c.quantity = c.quantity + ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $change, $id);
        $result = $stmt->execute();
        if ($result) {
            $cartDetail = $this->getItemById($this->getTableName(), $id);
            return $cartDetail;
        }
    }
}
