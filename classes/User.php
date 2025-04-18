<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/classes/traits/ItemOperations.php";

use Classes\Traits\ItemOperations;

class User
{
    use ItemOperations;
    protected static $table = 'users';
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function login(string $email, string $password)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($email && ($password === $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION["role"] = $user['role'];
            $_SESSION["session_version"] = $user['session_version'];
            return true;
        }
        return false;
    }

    public function addUser(string $firstName, string $lastName, string $email, string $password)
    {
        session_start();
        $query = "INSERT INTO " . self::$table . " (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        try {
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
            $stmt->execute();
            return true;
        } catch (\Throwable $th) {
            $_SESSION['invalid_input'] = [
                'messaage' =>  $stmt->errno === 1062 ? 'This email is already registered' : 'An error occurred: '
            ];
        }
        $stmt->close();
        return false;
    }

    public function updateRole(int $userId, string $role)
    {
        $query = "UPDATE " . self::$table . " SET role = ?, session_version = session_version + 1 WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $role, $userId);
        return  $stmt->execute();
    }
}
