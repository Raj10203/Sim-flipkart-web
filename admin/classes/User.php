<?php

namespace Admin\Classes;

require_once('../../classes/traits/ItemOperations.php');

class User extends Database
{
    private static $table = "users";

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
        $response['status'] = false;
        try {
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
            $stmt->execute();
            $response = [
                'status' => true,
                'message' => 'Account created successfully'
            ];
        } catch (\Throwable $th) {
            $response['message'] =  $stmt->errno === 1062 ? 'This email is already registered' : 'An error occurred: ';
        }
        $stmt->close();
        return $response;
    }
}
