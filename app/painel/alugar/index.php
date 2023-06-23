<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once '/app/config/authenticate.php';


require_once '/app/config/config.php';

require_once '/app/painel/alugar/alugar.php';
$id_user = $_SESSION["id"];
$query_user = $BibliotecaMCQuery->GetInfoOperadores((int)$id_user, 0);
$user = $query_user[0];

if (!$user["is_superuser"] and !$user["is_staff"]) {
    echo "Você não tem permissão para acessar essa pagina";
    exit;
} elseif ($user["is_staff"] == 0 and $user["is_superuser"] == 0) {
    echo "Você não tem permissão para acessar essa pagina";
    exit;
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alugar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    if ($user["is_superuser"] and $user["is_staff"]) {
        include "/app/painel/header-admin.php";
    } else {
        include "/app/painel/header-op.php";
    }
    ?>


    <main class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Alugar um livro
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="row g-3">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <label class="form-label" for="search_livro">procurar livro</label>
                                    <div class="input-group">
                                        <input class="form-control" type="search" name="nome_livro" id="search_livro">
                                        <button class="btn btn-outline-secondary" id="btn-buscar">
                                            buscar
                                        </button>
                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <label class="form-label" for="data">Data prevista para entrega:</label>
                                    <input type="date" class="form-control" id="data" name="data">
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <label for="aluno" class="form-label">Aluno que está alugando</label>
                                    <?php

                                    $n = $_GET["id_aluno"];

                                    if ($n) {
                                        $consultaAlunos = $AlunosQuery->GetInfoAlunos($n, 0);
                                        if (!empty($consultaAlunos)) {
                                            $aluno = $consultaAlunos[0];
                                            echo "<input type='text' name='aluno' readonly class='form-control form-control-plaintext' id='aluno' value=' 👨‍🎓 " . $aluno["nomealuno"] . " " . $aluno["turma"] . "'>";
                                            echo "<input type='hidden' name='idaluno' id='aluno' value='" . $aluno["idaluno"] . "'>";
                                        } else {
                                            echo "<input type='text' readonly class='form-control-plaintext' id='aluno' value='nenhum aluno encontrado'>";
                                        }
                                    } else {
                                        echo "<input type='text' readonly class='form-control-plaintext' id='aluno' value='Não foi passado nenhum aluno'>";
                                    }
                                    ?>

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <label class="form-label" for="floatingSelect">Resultado da pesquisa</label>
                                    <div class="form-floating">
                                        <select name="livro" class="form-select" id="floatingSelect" aria-label="Floating label select example">
                                            <option value="0" selected>Nenhum livro encontrado</option>
                                        </select>
                                        <label for="floatingSelect">Livros</label>
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button class="btn btn-success">
                                        alugar
                                    </button>
                                </div>
                                <div class="col-12">
                                    <?php
                                    if (VerificarCampos()) {
                                        $resp = SalvarAluguel();
                                        if ($resp[0]) {
                                            echo "<div class='alert alert-success'>";
                                            echo $resp[1];
                                            echo "</div>";
                                        } else {
                                            echo "<div class='alert alert-danger'>";
                                            echo $resp[1];
                                            echo "</div>";
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            if (isset($_GET["id_aluno"])) {
                include "/app/painel/alugar/card-aluno.php";
            }
            ?>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="/static/js/scriptAlugar.js"></script>
    <script src="/static/js/scriptRenderAlugar.js"></script>
</body>

</html>