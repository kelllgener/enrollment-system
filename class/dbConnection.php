<?php
session_start();

class DbConfig {

    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "enroll";

    public function getConnection() {

        $conn = new mysqli(
            $this->servername, 
            $this->username, 
            $this->password, 
            $this->dbname); // Create connection
            
            return $conn;

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error); 
    } 

    }

    public function backupDatabase() {
        
    }
    
}

?>