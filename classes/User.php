<?php

namespace Classes;

use Classes\Traits\ItemOperations;

class User extends Database
{
    use ItemOperations;

    protected static $table = 'users';

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
            $_SESSION["role"] = $user['role'];
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
}
