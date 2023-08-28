<?php
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';
include_once '../../br.edu.ifsp.pep.dao/ContaDAO.php';
include_once '../service/TitularService.php';
include_once '../service/ContaService.php';

$titularDAO = new TitularDAO();

$titulares = $titularDAO->buscarTodosSemConta();

$contaDAO = new ContaDAO();

$conta = $contaDAO->buscarPorId($_GET['agencia'], $_GET['numero']);
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
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
                            <a class="nav-link active" href="list.php">Contas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="create.php">Abrir Conta</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <div class="mb-3">
                        <a href="list.php" type="button" class="btn btn-secondary">Voltar</a>
                    </div>
                    <div class="card">
                        <form class="row g-3" action="depositar.php?conta=2&agencia=<?php echo $conta->getAgencia(); ?>&numero=<?php echo $conta->getNumero(); ?>" method="POST">
                            <div class="col-md-6">
                                <label for="titular" class="form-label">Titular</label>
                                <input name="titular" disabled type="text" class="form-control" id="titular" value="<?php echo $conta->getTitular()->getNome(); ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="conta" class="form-label">Conta</label>
                                <input name="conta" disabled type="text" class="form-control" id="conta" value="<?php echo substr_replace(get_class($conta), " ", 5, 0); ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="valor" class="form-label">Valor de Saque</label>
                                <input name="valor" type="text" class="form-control" id="valor">
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-secondary">Sacar</button>
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
        <script>
            $(document).ready(function () {
                $('#valor').inputmask("currency", {
                    prefix: "R$ ",
                    alias: "numeric",
                    digits: 2,
                    radixPoint: ",",
                    groupSeparator: ".",
                    autoGroup: true,
                    autoUnmask: true
                });
            });
        </script>


        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    </body>
</html>
