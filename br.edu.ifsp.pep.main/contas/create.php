<?php
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';
include_once '../service/TitularService.php';
include_once '../service/ContaService.php';

$titularDAO = new TitularDAO();

$titulares = $titularDAO->buscarTodosSemConta();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Banco</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
       <style>
            .card {
                border: none;
            }
        </style>

    </head>
    <body>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="../titular/list.php">Titular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list.php">Contas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="create.php">Abrir Conta</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <div class="mb-5">

                    </div>
                    <div class="card">
                        <form class="row g-3" action="create.php?conta=0" method="POST">
                            <div class="col-md-12">
                                <label for="titular" class="form-label">Titular</label>
                                <select required name="titular" id="titular" class="form-select">
                                    <option selected value="">Escolha...</option>
                                    <?php
                                    foreach ($titulares as $titular) {
                                        echo "<option value='" . $titular->getId() . "'>" . $titular->getNome() . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="agencia" class="form-label">Agência</label>
                                <input name="agencia" type="number" class="form-control" id="agencia">
                            </div>
                            <div class="col-md-6">
                                <label for="numero" class="form-label">Número</label>
                                <input name="numero" type="number" class="form-control" id="numero">
                            </div>
                            <div class="col-md-12">
                                <label for="tipo" class="form-label">Tipo Conta</label>
                                <select name="tipo" id="tipo" onchange="ativar()" class="form-select">
                                    <option selected>Escolha...</option>
                                    <option value="1">Conta Corrente</option>
                                    <option value="2">Conta Poupança</option>
                                </select>
                            </div>
                            <div id="divLimite" hidden="true" class="col-md-6">
                                <label for="inputLimite" class="form-label">Limite</label>
                                <input name="limite" value="0" type="number" class="form-control" id="inputLimite">
                            </div>
                            <div id="divTaxa" hidden="true" class="col-md-6">
                                <label for="inputTaxa" class="form-label">Taxa</label>
                                <input name="taxa"  step="0.01" value="0" type="number" class="form-control" id="inputTaxa">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-secondary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function ativar() {
                let inputTypeValue = document.getElementById("tipo").value;
                console.log(inputTypeValue);
                if (inputTypeValue == 1) {
                    document.getElementById("divLimite").hidden = false;
                    document.getElementById("divTaxa").hidden = false;
                } else {
                    document.getElementById("divLimite").hidden = true;
                    document.getElementById("divTaxa").hidden = true;
                }
            }
        </script>


        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    </body>
</html>
