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

    public function addOrder($paymentId)
    {
        $query = "INSERT INTO " . self::$table . " (user_id, status, payment_id) VALUES (?, 'paid', ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("is", $_SESSION['user_id'], $paymentId);
        $stmt->execute();
        $orderId = $stmt->insert_id;
        return $orderId;
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
