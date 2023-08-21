<?php

include_once 'Conexao.php';
include_once '../br.edu.ifsp.pep.model/Titular.php';

class TitularDAO {
    private Conexao $conexao;
    
      public function __construct() {
        $this->conexao = new Conexao("root", "ifsp");
    }

    public function inserir(Titular $titular) {
        try {
            $stmt = $this->conexao->conn->prepare('INSERT INTO titular VALUES(:id, :nome, :email, :endereco');
            $stmt->bindParam(':id', $titular->getId(), PDO::PARAM_INT);
            $stmt->bindParam(':nome', $titular->getNome(), PDO::PARAM_STR);
            $stmt->bindParam(':email', $titular->getEmail(), PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $titular->getEndereco(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public function atualizar(){}
}
