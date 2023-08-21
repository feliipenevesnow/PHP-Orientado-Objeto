<?php

include_once 'Titular.php';

class ContaPoupanca extends Conta {

    public function __construct(Titular $titular, Integer $agencia, Integer $numero) {
        parent::__construct($titular, $agencia, $numero);
    }

    public function __destruct() {
        echo 'Destroying: ', $this->name, PHP_EOL;
    }

    public function depositar(double $valor): bool {
        if ($valor > 0) {
            $this->setSaldo($this->getSaldo() + $valor);
            echo "Valor depositado com sucesso!";
            return true;
        } else {
            echo "Valor inválido.";
            return false;
        }
    }

    public function sacar(double $valor): bool {
        if ($this->getSaldo() >= $valor) {
            $this->setSaldo($this->getSaldo() - $valor);

            echo "Valor sacado com sucesso!";

            return true;
        } else {
            echo "Saldo insuficiente.";

            return false;
        }
    }

    public function atualizar(double $taxaRendimento): void {
        $saldoAtualizado = $this->getSaldo() * $taxaRendimento / 100;
        $this->setSaldo($saldoAtualizado);
    }
}
