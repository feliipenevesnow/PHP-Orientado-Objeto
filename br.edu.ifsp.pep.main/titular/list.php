<?php
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';
include_once '../../br.edu.ifsp.pep.dao/ContaDAO.php';
include_once '../service/TitularService.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Banco</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <style>
            .card {
                border: none;
            }
            a{
                color: black;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="../titular/list.php">Titular</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contas/list.php">Contas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../contas/create.php">Abrir Conta</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="mb-3 col-md-8">
                    <a href="create.php" type="button" class="btn btn-secondary">Cadastrar</a>
                </div>
                <div class="col-md-8">
                    <div class="col-md-12 mb-3">
                        <form class="row g-3" action="list.php" method="POST">
                            <div class="col-md-10">
                                <?php
                                if (!isset($_POST["nome"])) {
                                    ?>
                                    <input placeholder="Pesquise por nome." type="text" name="nome" class="form-control" id="nomePesquisar">
                                    <?php
                                } else {
                                    if ($_POST["nome"] == "") {
                                        ?>
                                        <input placeholder="Pesquise por nome." type="text" name="nome" class="form-control" id="nomePesquisar">
                                        <?php
                                    } else {
                                        ?>
                                        <input value="<?php echo $_POST["nome"]; ?>" type="text" name="nome" class="form-control" id="nomePesquisar">
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-secondary">Pesquisar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Endereço</th>
                                    <th scope="col">Conta</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Excluir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $titularDAO = new TitularDAO();

                                if (!isset($_POST["nome"])) {
                                    $titulares = $titularDAO->buscarTodos();
                                } else {
                                    $titulares = $titularDAO->buscarPorNome($_POST["nome"]);
                                }


                                $contador = 0;

                                if (isset($titulares)) {
                                    foreach ($titulares as $titular) {
                                        $contador++;
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $contador; ?></th>
                                            <td><?php echo $titular->getNome(); ?></td>
                                            <td><?php echo $titular->getEmail(); ?></td>
                                            <td><?php echo $titular->getEndereco(); ?></td>
                                            <td><?php
                                                $contaDAO = new ContaDAO();
                                                $conta = $contaDAO->buscarPorTitular($titular);

                                                if (isset($conta)) {
                                                    echo "Sim";
                                                } else {
                                                    echo "Não";
                                                }
                                                ?></td>
                                            <td><a href="update.php?titularID=<?php echo $titular->getId(); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> </td>
                                            <td><a href="list.php?titular=2&titularID=<?php echo $titular->getId(); ?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    echo "<tr><td>Não há registro.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    </body>
</html>