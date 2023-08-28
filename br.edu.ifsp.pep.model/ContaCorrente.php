<?php

include_once 'Titular.php';

class ContaCorrente extends Conta {

    private float $taxa;
    private float $limite;

    public function __construct(Titular $titular, int $agencia, int $numero, String $tipo, float $saldo) {
        parent::__construct($titular, $agencia, $numero, $tipo, $saldo);
    }

    public function __destruct() {
     
    }

    public function getTaxa(): float {
        return $this->taxa;
    }

    public function getLimite(): float {
        return $this->limite;
    }

    public function setTaxa(float $taxa): void {
        $this->taxa = $taxa;
    }

    public function setLimite(float $limite): void {
        $this->limite = $limite;
    }

    public function getSaldoComLimite(): float {
        return $this->getSaldo() + $this->limite;
    }

    public function depositar(float $valor): bool {
        if ($valor > 0) {
            $this->setSaldo($this->getSaldo() + $valor - $taxa);
            echo "Valor depositado com sucesso!";
            return true;
        } else {
            echo "Valor inválido.";
            return false;
        }
    }

     public function sacar(float $valor): bool {
        if ($valor < 0 && $this->getSaldoComLimite() < $valor) return false;
        $this->setSaldo($this->getSaldo() - $valor + $taxa);
        return true;
    }

}
