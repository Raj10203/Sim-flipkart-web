<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/traits/ItemOperations.php";

use Classes\Traits\ItemOperations;

class Order
{
    use ItemOperations;
    protected static $table = 'orders';
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function addOrder(string $paymentIntent, int $user_id, int $total_products, float $total_amount)
    {
        $query = "INSERT INTO " . self::$table . " (user_id, status, total_products, total_price, payment_id) VALUES (?, 'paid', ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("iiis", $user_id, $total_products, $total_amount, $paymentIntent);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        return $orderId;
    }

    public function getOrderByUserId(int $userId)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE user_id = ? order by created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);
        return $orders;
    }

    public function updateStatus(int $orderId, string $status)
    {
        $query = "UPDATE " . self::$table . " SET status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $status, $orderId);
        return  $stmt->execute();;
    }
}
