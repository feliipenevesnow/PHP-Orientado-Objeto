<?php

include_once 'Conexao.php';
include_once '../../br.edu.ifsp.pep.model/Titular.php';
include_once 'ContaDAO.php';

class TitularDAO {

    private $conexao;

    public function __construct() {
        
    }

    public function inserir(Titular $titular) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('INSERT INTO titular (nome, email, endereco) VALUES(:nome, :email, :endereco)');

            $nome = $titular->getNome();
            $email = $titular->getEmail();
            $endereco = $titular->getEndereco();

            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stmt->execute();
            Conexao::closeConnection($this->conexao);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function atualizar(Titular $titular) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('UPDATE titular SET nome = :nome, email = :email, endereco = :endereco WHERE idTitular = :idTitular');

            $idTitular = $titular->getId();
            $nome = $titular->getNome();
            $email = $titular->getEmail();
            $endereco = $titular->getEndereco();

            $stmt->bindParam(':idTitular', $idTitular, PDO::PARAM_INT);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
            $stmt->execute();
            Conexao::closeConnection($this->conexao);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function deletar(int $id) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('DELETE FROM titular WHERE idTitular = :idTitular');
            $stmt->bindParam(':idTitular', $id, PDO::PARAM_INT);
            $stmt->execute();
            Conexao::closeConnection($this->conexao);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function buscarPorId(int $id): Titular {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM titular WHERE idTitular = :idTitular');
            $stmt->bindParam(':idTitular', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);
            return $result ? new Titular($result['idTitular'], $result['nome'], $result['email'], $result['endereco']) : null;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return null;
        }
    }

    public function buscarTodos() {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM titular');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            $titulares = [];
            foreach ($results as $result) {
                $titulares[] = new Titular($result['idTitular'], $result['nome'], $result['email'], $result['endereco']);
            }
            return $titulares;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return [];
        }
    }
    
     public function buscarPorNome($nome) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare("SELECT * FROM titular WHERE nome LIKE :nome");
            $nome =  "%".$nome."%";
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            $titulares = [];
            foreach ($results as $result) {
                $titulares[] = new Titular($result['idTitular'], $result['nome'], $result['email'], $result['endereco']);
            }
            return $titulares;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return [];
        }
    }
    
       public function buscarTodosSemConta() {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM titular');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            $titulares = [];
            $contaDAO = new ContaDAO();
            
            foreach ($results as $result) {
                $titular = new Titular($result['idTitular'], $result['nome'], $result['email'], $result['endereco']);
                
                $contas = $contaDAO->buscarPorTitular($titular);
                
                if($contas == null){
                    $titulares[] = $titular;
                }
            }
            return $titulares;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return [];
        }
    }
}
