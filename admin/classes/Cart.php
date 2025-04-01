<?php
namespace Admin\Classes;

require_once('../../classes/traits/ItemOperations.php');
use Admin\Classes\Traits\ItemOperations;
use Admin\Classes\Product;

class Cart
{
    use ItemOperations;
    protected $conn;
    protected $table = 'cart';
    public function __construct(Database $db)
    {
        $this->db = $db;
        $this->conn = $db?->connect();
    }

    public function addToCart($userId, $productId)
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
            $query = "INSERT INTO " . $this->table . " (user_id, product_id) VALUES (?, ?)";
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

    public function gettAllCartByUserId($userId){
        $query = "SELECT c.id as id, c.quantity as quantity, p.id as productId, p.name, p.price, p.image_path, p.discount FROM " . $this->table . " c JOIN products p on c.product_id = p.id  WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartsByUserId = [];
        while ($row = $result->fetch_assoc()) {
            $cartsByUserId[] = $row;
        }
        return $cartsByUserId;
    }

    public function changeQuanityById($id, $change)
    {
        $query = "UPDATE " . $this->table . " c SET c.quantity = c.quantity + ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $change, $id); // 's' for strings, 'i' for integer
        $result = $stmt->execute();
        if($result) {
            $cartDetail = $this->getItemById($this->getTableName(),$id);
            return $cartDetail;
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
