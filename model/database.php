<?php

    class Database {

        private static $instance = null;
        private $conn;

        //Development
        private $server = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "student4u";

        //Deployment
        // private $server = "sql6.freemysqlhosting.net";
        // private $username = "sql6502402";
        // private $password = "Abj6cNqSFE";
        // private $dbname = "sql6502402";

        private function __construct() {

            $this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname) or die($this->conn);
        }

        public static function getInstance() {

            if(!self::$instance) {
                self::$instance = new Database();
            }

            return self::$instance;
        }

        public function getDBConnection() {
            return $this->conn;
        }
    }

?>