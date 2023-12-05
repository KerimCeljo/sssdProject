<?php

class Dao {

    public $conn;

    /**
    * constructor of dao class
    */
    public function __construct(){

      
        try {


        $servername = "localhost";
        $username = "root";
        $password = "root";
        $schema = "sssdproject";


          $this->conn = new PDO("mysql:host=$servername;dbname=$schema", $username, $password);
        // set the PDO error mode to exception
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          echo "Connected successfully";
        } catch(PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
        }
        
    }

    
}
?>













