<?php

include_once 'Titular.php';

abstract class Conta {

    private Integer $agencia;
    private Integer $numero;
    private Titular $titular;
    protected double $saldo;

    public function __construct(Titular $titular, Integer $agencia, Integer $numero) {
        $this->agencia = $agencia;
        $this->numero = $numero;
        $this->titular = $titular;
    }

    public function __destruct() {
        echo 'Destroying: ', $this->name, PHP_EOL;
    }

    public function getAgencia(): Integer {
        return $this->agencia;
    }

    public function getNumero(): Integer {
        return $this->numero;
    }

    public function getSaldo(): double {
        return $this->saldo;
    }

    public function setAgencia(Integer $agencia): void {
        $this->agencia = $agencia;
    }

    public function setNumero(Integer $numero): void {
        $this->numero = $numero;
    }

    public function setSaldo(double $saldo): void {
        $this->saldo = $saldo;
    }

    public function getTitular(): Titular {
        return $this->titular;
    }

    public function setTitular(Titular $titular): void {
        $this->titular = $titular;
    }

    abstract public function sacar(double $valor): bool;

    abstract public function depositar(double $valor): bool;

    public function transferir(double $valor, Conta $outra): bool {
        if ($this->saldo >= $valor) {

            $this->sacar($valor);
            $outra->depositar($valor);

            echo "Transferido com sucesso!";

            return true;
        } else {

            echo "Saldo insuficiente.";

            return false;
        }
    }
}
