<?php

include_once 'Titular.php';

abstract class Conta {

    private int $agencia;
    private int $numero;
    private Titular $titular;
    protected float $saldo = 0.0;
    private String $tipo;

    public function __construct(Titular $titular, int $agencia, int $numero, String $tipo, float $saldo) {
        $this->agencia = $agencia;
        $this->numero = $numero;
        $this->titular = $titular;
        $this->tipo = $tipo;
        $this->saldo = $saldo;
    }

    public function __destruct() {
        echo 'Destroying: ', $this->name, PHP_EOL;
    }
    
    public function getTipo(): String {
        return $this->tipo;
    }

    public function setTipo(String $tipo): void {
        $this->tipo = $tipo;
    }

    public function getAgencia(): int {
        return $this->agencia;
    }

    public function getNumero(): int {
        return $this->numero;
    }

    public function getSaldo(): float {
        return $this->saldo;
    }

    public function setAgencia(int $agencia): void {
        $this->agencia = $agencia;
    }

    public function setNumero(int $numero): void {
        $this->numero = $numero;
    }

    public function setSaldo(float $saldo): void {
        $this->saldo = $saldo;
    }

    public function getTitular(): Titular {
        return $this->titular;
    }

    public function setTitular(Titular $titular): void {
        $this->titular = $titular;
    }

    abstract public function sacar(float $valor): bool;

    abstract public function depositar(float $valor): bool;

    public function transferir(float $valor, Conta $outra): bool {
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
