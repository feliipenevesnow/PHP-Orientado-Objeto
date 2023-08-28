<?php

include_once 'Titular.php';

class ContaPoupanca extends Conta {

    public function __construct(Titular $titular, int $agencia, int $numero, String $tipo, float $saldo) {
        parent::__construct($titular, $agencia, $numero, $tipo, $saldo);
    }

    public function __destruct() {
    }

    public function depositar(float $valor): bool {
        if ($valor > 0) {
            $this->setSaldo($this->getSaldo() + $valor);
            return true;
        } else {
            return false;
        }
    }

    public function sacar(float $valor): bool {
        if ($this->getSaldo() >= $valor) {
            $this->setSaldo($this->getSaldo() - $valor);
            return true;
        } else {
            return false;
        }
    }

    public function atualizar(float $taxaRendimento): void {
        $saldoAtualizado = $this->getSaldo() * $taxaRendimento / 100;
        $this->setSaldo($saldoAtualizado);
    }
}
