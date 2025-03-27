<?php
namespace Admin\Classes;
class Product
{
    protected $conn;
    protected $table = 'products';

    public function __construct(Database $db)
    {
        $this->conn = $db?->connect();
    }

    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        return $product;
    }

    public function addProduct(){
        
    }

    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
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
