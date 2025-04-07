<?php

namespace Admin\Classes;

use Admin\Classes\Traits\ItemOperations;

class OrderItems extends Database
{
    use ItemOperations;

    protected static $table = 'order_items';

    public function insertOrderItem(int $orderId, int $productId, int $quantity, float $finalPrice)
    {
        $query = "INSERT INTO " . self::$table . " (order_id, product_id, quantity, final_price) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiid", $orderId, $productId, $quantity, $finalPrice);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        return $orderId;
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
