<?php
include_once '../../br.edu.ifsp.pep.dao/TitularDAO.php';
include_once '../../br.edu.ifsp.pep.dao/ContaDAO.php';
include_once '../service/ContaService.php';
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

            .escondido{
                visibility: hidden;
            }

            .mostra{
                visibility: visible;
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
                    <div class="col-md-12 mb-3">
                        <form class="row g-3" action="list.php" method="POST">
                            <div class="col-md-10">
                                <?php
                                if (!isset($_POST["nome"])) {
                                    ?>
                                    <input placeholder="Pesquise por nome de titular." type="text" name="nome" class="form-control" id="nomePesquisar">
                                    <?php
                                } else {
                                    if ($_POST["nome"] == "") {
                                        ?>
                                        <input placeholder="Pesquise por nome de titular." type="text" name="nome" class="form-control" id="nomePesquisar">
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
                                    <th scope="col">Titular</th>
                                    <th scope="col">Agência</th>
                                    <th scope="col">Número</th>
                                    <th scope="col">Saldo</th>
                                    <th scope="col">Taxa</th>
                                    <th scope="col">Limite</th>
                                    <th scope="col">Depositar</th>
                                    <th scope="col">Sacar</th>
                                    <th scope="col">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $contaDAO = new ContaDAO();

                                if (!isset($_POST["nome"])) {
                                    $contas = $contaDAO->buscarTodos();
                                } else {
                                    $contas = $contaDAO->buscarContaPorNomeTitular($_POST['nome']);
                                }

                                $contador = 0;

                                foreach ($contas as $conta) {
                                    $contador++;
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $contador; ?></th>
                                        <td><?php echo $conta->getTitular()->getNome(); ?></td>
                                        <td><?php echo $conta->getAgencia(); ?></td>
                                        <td><?php echo $conta->getNumero(); ?></td>
                                        <td>
                                            <div class="mostra">
                                                -
                                            </div>
                                            <div class="escondido">
                                                R$ <?php echo $conta->getSaldo(); ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mostra">
                                                -
                                            </div>
                                            <div class="escondido">
                                                <?php
                                                if ($conta instanceof ContaCorrente) {
                                                    echo $conta->getTaxa() . "%";
                                                } else {
                                                    echo "-";
                                                }
                                                ?>

                                            </div>
                                        </td>
                                        <td>
                                            <div class="mostra">
                                                -
                                            </div>
                                            <div class="escondido">
                                                <?php
                                                if ($conta instanceof ContaCorrente) {
                                                    echo "R$ " . $conta->getLimite();
                                                } else {
                                                    echo "-";
                                                }
                                                ?></td>  
                                        </div>
                                        <td>
                                            <a href="depositar.php?agencia=<?php echo $conta->getAgencia() ?>&numero=<?php echo $conta->getNumero() ?>"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                                        </td>
                                        <td>
                                            <a href="sacar.php?agencia=<?php echo $conta->getAgencia() ?>&numero=<?php echo $conta->getNumero() ?>"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                                        </td>
                                        <td>
                                            <div class="mostra">
                                                <i class="fa fa-eye" onclick="mudarEstado(this)" aria-hidden="true"></i>
                                            </div>
                                            <div class="escondido">
                                                <i class="fa fa-low-vision" onclick="mudarEstado(this)" aria-hidden="true"></i>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function mudarEstado(element) {
                const divsToToggle = element.parentNode.parentNode.parentNode.querySelectorAll('.mostra, .escondido');
                divsToToggle.forEach(div => {
                    if (div.classList.contains('mostra')) {
                        div.hidden = true;
                        div.classList.remove('mostra');
                        div.classList.add('escondido');
                    } else if (div.classList.contains('escondido')) {
                        div.hidden = false;
                        div.classList.remove('escondido');
                        div.classList.add('mostra');
                    }
                });
            }

        </script>




        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
    </body>
</html>



