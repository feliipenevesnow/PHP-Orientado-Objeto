<?php

include_once '../../br.edu.ifsp.pep.model/Conta.php';
include_once '../../br.edu.ifsp.pep.dao/ContaDAO.php';
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';

//Inicia Controlador
if (!isset($_GET['conta'])) {
    $_GET['conta'] = -1;
}


//Controle
switch ($_GET['conta']) {
    case 0:
        inserirConta($_POST["tipo"], $_POST["limite"], $_POST["taxa"], $_POST["agencia"], $_POST["numero"], $_POST["titular"]);
        break;
    case 1:
        depositar($_GET['agencia'], $_GET['numero'], $_POST['valor']);
        break;
    case 2:
        sacar($_GET['agencia'], $_GET['numero'], $_POST['valor']);
        break;
}

//Métodos
function inserirConta($tipo, $limite, $taxa, $agencia, $numero, $titular) {

    $contaDAO = new ContaDAO();
    $titularDAO = new TitularDAO();

    $titular = $titularDAO->buscarPorId($titular);

    if ($tipo == 1) {
        $conta = new ContaCorrente($titular, $agencia, $numero, $tipo, 0);
        $conta->setLimite($limite);
        $conta->setTaxa($taxa);

        $contaDAO->inserir($conta);
    } else {
        $conta = new ContaPoupanca($titular, $agencia, $numero, $tipo, 0);
        $contaDAO->inserir($conta);
    }

    echo "<script>alert('Cadastrado Com Sucesso!');</script>";
}

function depositar($agencia, $numero, $valor) {
    $formatar = str_replace(array('R$ ', ','), array('', '.'), $valor);

    $valor = (float) $formatar;

    $contaDAO = new ContaDAO();
    $conta = $contaDAO->buscarPorId($agencia, $numero);

    $result = $conta->depositar($valor);

    if ($result) {
        echo "<script>alert('Depósito Realizado com Sucesso!');</script>";
    } else {
        echo "<script>alert('Valor inválido!')</script>";
    }

    $contaDAO->atualizar($conta);

    header("Location: list.php");
}




function sacar($agencia, $numero, $valor) {
    $formatar = str_replace(array('R$ ', ','), array('', '.'), $valor);

    $valor = (float) $formatar;

    $contaDAO = new ContaDAO();
    $conta = $contaDAO->buscarPorId($agencia, $numero);

    $result = $conta->sacar($valor);

       if ($result) {
        echo "<script>alert('Saque Realizado com Sucesso!');</script>";
    } else {
        echo "<script>alert('Saldo insuficiente!')</script>";
    }

    $contaDAO->atualizar($conta);

    header("Location: list.php");
}
