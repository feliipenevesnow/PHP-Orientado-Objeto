<?php

include_once '../../br.edu.ifsp.pep.model/Titular.php';
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';

//Inicia Controlador
if (!isset($_GET['titular'])) {
    $_GET['titular'] = -1;
}


//Controle
switch ($_GET['titular']) {
    case 0:
        inserirTitular($_POST['nome'], $_POST['email'], $_POST['endereco']);
        break;
    case 1:
        atualizarTitular($_GET['id'], $_POST['nome'], $_POST['email'], $_POST['endereco']);
        break;
    case 2:
        deletarTitular($_GET['titularID']);
        break;
}


//Métodos
function inserirTitular($nome, $email, $endereco) {
    $titular = new Titular(0, $nome, $email, $endereco);

    $titularDAO = new TitularDAO();

    $titularDAO->inserir($titular);

    echo "<script>alert('Cadastrado Com Sucesso!');</script>";
}

function atualizarTitular($id, $nome, $email, $endereco) {
    $titular = new Titular($id, $nome, $email, $endereco);

    $titularDAO = new TitularDAO();

    $titularDAO->atualizar($titular);

    header("Location: ../titular/list.php");
}

function deletarTitular($titular) {
    $titularDAO = new TitularDAO();

    $titularDAO->deletar($titular);

    echo "<script>alert('Deletado Com Sucesso!');</script>";
}
