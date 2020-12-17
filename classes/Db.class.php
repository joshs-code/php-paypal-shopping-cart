<?php

class Db {
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $pass = '';
    private $dbName = 'ecommerceone';

    public function connect() {
        try {
            $dsn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
            $conn = new PDO($dsn, $this->dbUser, $this->pass);
            $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $conn;
        } catch(PDOException $e) {
            die("DB Connection Failed " . $e);

        }
    }

}