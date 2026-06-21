<?php
    class Database{
        private $host;
        private $user;
        private $pass;
        private $database;
        public $conn;

        function __construct($host, $user, $pass, $database){
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->database = $database;
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->database);

            if($this->conn->connect_error){
                die("Connection failed");
            }
        }
    }
    class Book extends Database{
        public function getBooks(){
            return $this->conn->query("SELECT * FROM books");
        }
    }
    class Order extends Database {
        public function getOrders(){
            return $this->conn->query("SELECT * FROM orders");
        }
    }
    class Category extends Database {
        public function getCategories(){
            return $this->conn->query("SELECT * FROM categories");
        }
    }
?>