<?php

namespace Admin\Classes;

use Admin\Classes\Traits\ItemOperations;

class Order
{
    use ItemOperations;
    protected $conn;
    protected static $table = 'orders';

    public function __construct(Database $db)
    {
        $this->conn = $db?->connect();
    }

    public function addOrder($paymentId, $user_id, $total_products, $total_amount)
    {
        $query = "INSERT INTO " . self::$table . " (user_id, status, total_products, total_price, payment_id) VALUES (?, 'paid', ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiis", $user_id, $total_products, $total_amount, $paymentId);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        return $orderId;
    }

    public function getOrderByUserId($userId)  {
        $query = "SELECT * FROM " . self::$table . " WHERE user_id = ? order by created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        return $orders;
    }

    public static function getTableName()
    {
        return self::$table;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
