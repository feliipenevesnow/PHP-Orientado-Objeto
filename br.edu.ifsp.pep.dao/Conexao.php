<?php

class Conexao extends PDO {
    public function __construct($dsn, $username = null, $password = null, array $options = null) {
        parent::__construct($dsn, $username, $password, $options);
    }

    static function getNewConnection() {
        $conn=null;
        try {
            $host = "localhost";
            $dbname = "exercicioBanco";
            $user = "root";
            $pass = "";
            $conn = new Conexao("mysql:host=$host;dbname=$dbname",$user,$pass);
        }
        catch (PDOException $exc) {
            echo $exc->getMessage();
        }
        return $conn;
    }

    static function closeConnection(&$conn) {
        $conn=null;
    }
}
