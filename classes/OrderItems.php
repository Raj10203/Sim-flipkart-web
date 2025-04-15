<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/traits/ItemOperations.php";

use Classes\Traits\ItemOperations;

class OrderItems
{
    use ItemOperations;
    protected static $table = 'order_items';
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function insertOrderItem(int $orderId, int $productId, int $quantity, float $finalPrice)
    {
        $query = "INSERT INTO " . self::$table . " (order_id, product_id, quantity, final_price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $finalPrice);
        return $stmt->execute();;
    }

    public function getItemsByOrderId(int $orderID)
    {
        $query = "SELECT * FROM " . self::$table . " oi JOIN " . Product::getTableName() . " p on oi.product_id = p.id  WHERE oi.order_id = ?";;
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $orderID);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = $result->fetch_all(MYSQLI_ASSOC);
        return $items;
    }
}
