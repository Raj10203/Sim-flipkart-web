<?php

namespace Admin\Classes;

use mysqli;

class Database
{
    private $host = "localhost";
    private $user = "raj@simform";
    private $password = "Raj123";
    private $dbname = "flipkart_db";
    protected $conn;

    public function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
