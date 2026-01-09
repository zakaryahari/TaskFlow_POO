<?php 

namespace App\Core;

class Database {
    private $host = "localhost";
    private $db_name = "TaskFlow";
    private $username = "root";
    private $password = "";
    private $port = "3307";
    private static $instance = null;
    private $conn;

    public function __construct() {
        try {
            $dns = "musql:host=" . $this->host . ";port=" . $this->port . "dbname=" . $this->db_name ;
            $this->conn = new PDO($dns , $this->username ,$this->password);
        }  catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function __clone() {}
    private function __wakeup() {}

    public static function getInstance(){
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(){
        return $this->conn;
    }
}

?>