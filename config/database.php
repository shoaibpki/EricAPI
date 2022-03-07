<?php
class Database
{
    private $host = 'localhost';
    private $db_name = 'eric';
    private $username = 'root';
    private $password = '123456';
    private $conn;

    //DB Connect
    public function connect()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
        } catch (PDOException $e) {
            echo 'Connection Error : ' . $e->getMessage();
        }
        return $this->conn;
    }
}
