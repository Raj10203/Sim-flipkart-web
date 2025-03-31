<?php
namespace Admin\Classes;

require_once('../../classes/traits/ItemOperations.php');
class User
{
    protected $conn;
    private $table = "users";

    public function __construct(Database $db)
    {
        $this->conn = $db->connect();
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($email && ($password == $user['password'])) {
            return $user;
        }
        return false;
    }
}
