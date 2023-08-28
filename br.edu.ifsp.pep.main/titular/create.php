<?php
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';
include_once '../service/TitularService.php';
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
                            <a class="nav-link active" aria-current="page" href="#">Titular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Abrir Conta</a>
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
                        <form class="row g-3" action="create.php?titular=0" method="POST">
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" id="inputEmail4">
                            </div>
                            <div class="col-md-6">
                                <label for="inputPassword4" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" id="inputPassword4">
                            </div>
                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Endereço</label>
                                <input type="text" name="endereco" class="form-control" id="inputAddress">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-secondary">Cadastrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    </body>
</html>
