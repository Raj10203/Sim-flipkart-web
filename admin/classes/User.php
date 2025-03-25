<?php

namespace Mysql_php\Classes;

class User
{
    protected $db;

    public $sql;

    protected $arr = [];

    protected $result;
    

    public function __construct($conn)
    {
        $this->db = $conn;
    }

    private function executeQuery()
    {
        $this->result = $this->db->query($this->sql);

        if ($this->result === false) {
            die("Error in query: " . $this->db->error);
        }

        if ($this->result->num_rows > 0) {

            while ($row = $this->result->fetch_assoc()) {
                $this->arr[] = $row;
            }
        }
    }

    public function getAllUsers()
    {
        $this->sql = "SELECT * FROM users";
        $this->executeQuery();
        return $this->arr;
    }

    public function getPasswordOfSingleUser($email)
    {
        if (!$email) {
            $this->arr['error'] = "empty UserName";
        } else {
            $this->sql = "SELECT password FROM users WHERE email = '$email'";
            $this->executeQuery();
            return $this?->arr[0]['password'];
        }
    }
}
