<?php

namespace Classes;

require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Dotenv\Dotenv;
use mysqli;

class Database
{
    private $host;
    private $user;
    private $password;
    private $dbname;
    private $port;
    protected $conn;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../'); // Adjust path if needed
        $dotenv->load();

        $this->host = $_ENV['DATABASE_HOSTNAME'];
        $this->user = $_ENV['DATABASE_USERNAME'];
        $this->password = $_ENV['DATABASE_PASSWORD'];
        $this->dbname = $_ENV['DATABASE_NAME'];
        $this->port = $_ENV['DATABASE_PORT'];
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname, $this->port);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
