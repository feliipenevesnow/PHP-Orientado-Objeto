<?php

include_once 'Conexao.php';
include_once 'TitularDAO.php';
include_once '../../br.edu.ifsp.pep.model/Conta.php';
include_once '../../br.edu.ifsp.pep.model/ContaCorrente.php';
include_once '../../br.edu.ifsp.pep.model/ContaPoupanca.php';

class ContaDAO { 

    private $conexao;

    public function __construct() {
        
    }

    public function inserir(Conta $conta) {
        try {
            $tipo = $conta->getTipo();
            $agencia = $conta->getAgencia();
            $numero = $conta->getNumero();
            $titular = $conta->getTitular()->getId();
            $saldo = 0;

            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('INSERT INTO conta (agencia, numero, titular, saldo, tipo, taxa, limite) VALUES(:agencia, :numero, :titular, :saldo, :tipo, :taxa, :limite)');
            $stmt->bindParam(':agencia', $agencia, PDO::PARAM_INT);
            $stmt->bindParam(':titular', $titular, PDO::PARAM_INT);
            $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
            $stmt->bindValue(':saldo', $saldo, PDO::PARAM_STR);
            $stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);

            if ($conta instanceof ContaCorrente) {
                $limite = $conta->getLimite();
                $taxa = $conta->getTaxa();
                $stmt->bindParam(':taxa', $taxa, PDO::PARAM_STR);
                $stmt->bindParam(':limite', $limite, PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':taxa', null, PDO::PARAM_NULL);
                $stmt->bindValue(':limite', null, PDO::PARAM_NULL);
            }

            $stmt->execute();
            Conexao::closeConnection($this->conexao);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function atualizar(Conta $conta) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('UPDATE conta SET saldo = :saldo WHERE agencia = :agencia AND numero = :numero');
            $stmt->bindParam(':agencia', $conta->getAgencia(), PDO::PARAM_INT);
            $stmt->bindParam(':numero', $conta->getNumero(), PDO::PARAM_INT);
            $stmt->bindParam(':saldo', $conta->getSaldo(), PDO::PARAM_STR);
            $stmt->execute();
            Conexao::closeConnection($this->conexao);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function deletar($agencia, $numero) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('DELETE FROM conta WHERE agencia = :agencia AND numero = :numero');
            $stmt->bindParam(':agencia', $agencia, PDO::PARAM_INT);
            $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
            $stmt->execute();
            Conexao::closeConnection($this->conexao);
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
        }
    }

    public function buscarPorId($agencia, $numero): Conta {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM conta WHERE agencia = :agencia AND numero = :numero');
            $stmt->bindParam(':agencia', $agencia, PDO::PARAM_INT);
            $stmt->bindParam(':numero', $numero, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            if ($result) {
                $tipoConta = $result['tipo'];

                $titularDAO = new TitularDAO();

                $titular = $titularDAO->buscarPorId($result['titular']);

                if ($tipoConta == "1") {
                    $conta = new ContaCorrente($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                    $conta->setLimite($result['limite']);
                    $conta->setTaxa($result['taxa']);
                } else {
                    $conta = new ContaPoupanca($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                }
                
                $conta->setSaldo($result['saldo']);

                return $conta;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return null;
        }
    }

    public function buscarPorTitular(Titular $titular) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM conta WHERE titular = :titular');
            $titularId = $titular->getId();
            $stmt->bindParam(':titular', $titularId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            if ($result) {
                $tipoConta = $result['tipo'];

                if ($tipoConta == "Corrente") {
                    $conta = new ContaCorrente($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                    $conta->setLimite($result['limite']);
                    $conta->setTaxa($result['taxa']);
                } else {
                    $conta = new ContaPoupanca($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                }

                return $conta;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return null;
        }
    }

    public function buscarTodos() {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM conta');
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            $titularDAO = new TitularDAO();

            $contas = [];
            foreach ($results as $result) {
                $tipoConta = $result['tipo'];

                $titular = $titularDAO->buscarPorId($result['titular']);

                if ($tipoConta == "1") {
                    $conta = new ContaCorrente($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                    $conta->setLimite($result['limite']);
                    $conta->setTaxa($result['taxa']);
                } else {
                    $conta = new ContaPoupanca($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                }
                $conta->setSaldo($result['saldo']);

                $contas[] = $conta;
            }
            return $contas;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return [];
        }
    }

    public function buscarContaPorNomeTitular($nome) {
        try {
            $this->conexao = Conexao::getNewConnection();
            $stmt = $this->conexao->prepare('SELECT * FROM conta INNER JOIN titular ON conta.titular = titular.idTitular WHERE titular.nome LIKE :nome');
            $nome = "%" . $nome . "%";
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            Conexao::closeConnection($this->conexao);

            $titularDAO = new TitularDAO();

            $contas = [];
            foreach ($results as $result) {
                $tipoConta = $result['tipo'];

                $titular = $titularDAO->buscarPorId($result['titular']);

                if ($tipoConta == "1") {
                    $conta = new ContaCorrente($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                    $conta->setLimite($result['limite']);
                    $conta->setTaxa($result['taxa']);
                } else {
                    $conta = new ContaPoupanca($titular, $result['agencia'], $result['numero'], $result['tipo'], $result['saldo']);
                }
                $conta->setSaldo($result['saldo']);

                $contas[] = $conta;
            }
            return $contas;
        } catch (PDOException $e) {
            echo 'ERROR: ' . $e->getMessage();
            return [];
        }
    }

}
