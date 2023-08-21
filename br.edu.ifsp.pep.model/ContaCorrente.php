<?php

include_once 'Titular.php';

class ContaCorrente extends Conta {

    private double $taxa;
    private double $limite;

    public function __construct(Titular $titular, Integer $agencia, Integer $numero) {
        parent::__construct($titular, $agencia, $numero);
    }

    public function __destruct() {
        echo 'Destroying: ', $this->name, PHP_EOL;
    }

    public function getTaxa(): double {
        return $this->taxa;
    }

    public function getLimite(): double {
        return $this->limite;
    }

    public function setTaxa(double $taxa): void {
        $this->taxa = $taxa;
    }

    public function setLimite(double $limite): void {
        $this->limite = $limite;
    }

    public function getSaldoComLimite(): double {
        return $this->getSaldo() + $this->limite;
    }

    public function depositar(double $valor): bool {
        if ($valor > 0) {
            $this->setSaldo($this->getSaldo() + $valor - $taxa);
            echo "Valor depositado com sucesso!";
            return true;
        } else {
            echo "Valor inválido.";
            return false;
        }
    }

     public function sacar(double $valor): bool {
        if ($valor < 0 && $this->getSaldoComLimite() < $valor) return false;
        $this->setSaldo($this->getSaldo() - $valor + $taxa);
        return true;
    }

}
