<?php

class Conexao {

    private $conn;

    public function __construct(String $username, String $senha) {
        $this->conn = $this->conectar($username, $senha);
    }

    public function conectar(String $username, String $senha) {
        try {
            $conn = new PDO('mysql:host=localhost;dbname=exercicioBanco', $username, $senha);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
}
