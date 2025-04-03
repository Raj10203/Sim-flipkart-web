<?php

namespace Admin\Classes;

require_once('../../classes/traits/ItemOperations.php');

class User
{
    protected $conn;
    private static $table = "users";

    public function __construct(Database $db)
    {
        $this->conn = $db->connect();
    }

    public function login($email, $password)
    {
        $query = "SELECT * FROM " . self::$table . " WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($email && ($password === $user['password'])) {
            return $user;
        }
        return false;
    }

    public function addUser($firstName, $lastName, $email, $password)
    {
        
        $query = "INSERT INTO " . self::$table . " (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        try {
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
            $stmt->execute();
            $response = [
                'status' => true,
                'message' => 'Account created successfully'
            ];
        } catch (\Throwable $th) {
            if ($stmt->errno === 1062) {
                $response = [
                    'status' => false,
                    'message' => 'This email is already registered'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'An error occurred: ' . $stmt->error
                ];
            }
        }
        $stmt->close();

        return $response;
    }
}
