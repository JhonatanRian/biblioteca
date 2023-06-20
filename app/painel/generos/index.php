<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once '/app/config/authenticate.php';


require_once '/app/config/config.php';

require_once '/app/painel/alugar/alugar.php';
$id_user = $_SESSION["id"];
$query_user = $BibliotecaMCQuery->GetInfoOperadores((int)$id_user, 0);
$user = $query_user[0];

if (!($user["is_superuser"] and $user["is_staff"]) and !(!$user["is_superuser"] and $user["is_staff"])) {
    echo "Você não tem permissão para acessar essa pagina";
    exit;
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    if ($user["is_superuser"] and $user["is_staff"]) {
        include "/app/painel/header-admin.php";
    } else {
        include "/app/painel/header-op.php";
    }
    global $camposObrigatoriosGenero;
    $camposObrigatoriosGenero = array(
        "nome",
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($camposObrigatoriosGenero as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $resp = array(false, "O campo '$campo' é obrigatório.");
                break;
            }
        }

        if (!isset($resp)) {
            $resp = $GeneroQuery->InsertEhUpdateGeneros("", $_POST["nome"]);
        }
    }
    ?>
    <?php
    if (!isset($_GET["page"]) && !isset($_GET["search"])) {
        $numGeneros = $GeneroQuery->CountGeneros("");
        $pages = (int)($numGeneros / $ELEMPAGES) + 1;
        $generos =  $GeneroQuery->GetGenerosPage($ELEMPAGES, 0);
    } else if (!isset($_GET["page"]) && isset($_GET["search"])) { // se não existir o page, mas existir o filter e search 
        $search = $_GET["search"];
        $numGeneros = $GeneroQuery->CountGeneros($search);
        $pages = (int)($numGeneros / $ELEMPAGES) + 1;
        $generos = $GeneroQuery->GetGenerosPageFilter($ELEMPAGES, 0, $search);
    } else if (isset($_GET["page"]) && isset($_GET["search"])) { // se existir o page e o filtro
        $page = $_GET["page"];
        $search = $_GET["search"];
        $numGeneros = $GeneroQuery->CountGeneros($search);
        $pages = (int)($numGeneros / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $generos = $GeneroQuery->GetGenerosPageFilter($ELEMPAGES, $offset, $search);
    } elseif (isset($_GET["page"]) && !isset($_GET["search"])) { // se exitir somente o page
        $numGeneros = $GeneroQuery->CountGeneros("");
        $page = $_GET["page"];
        $pages = (int)($numGeneros / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $generos = $GeneroQuery->GetGenerosPage($ELEMPAGES, $offset);
    } else {
        $numGeneros = $GeneroQuery->CountGeneros("");
        $pages = (int)($numGeneros / $ELEMPAGES) + 1;
        $generos =  $GeneroQuery->GetGenerosPage($ELEMPAGES, 0);
    }

    ?>
    <main class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Alunos
                    </div>
                    <div class="card-body">
                        <form action="." method="get">
                            <div class="input-group">
                                <input class="form-control border border-primary" type="search" name="search" id="search_livro" placeholder="Buscar genero">
                                <button class="btn btn-outline-secondary" type="submit" id="btn-buscar">
                                    buscar
                                </button>
                            </div>
                        </form>
                        <div class="row g-3">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="card mt-2">
                                    <div class="card-header">
                                        alunos cadastrados
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">id</th>
                                                    <th scope="col">nome</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($generos as $genero) {
                                                    $id_genero = $genero["idgenero"];
                                                    echo "<tr>";
                                                    echo "<td scope='row'>";
                                                    echo $genero["idgenero"];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo "<a class='text-decoration-none' href='/painel/generos/genero?id_genero=$id_genero'>";
                                                    echo $genero["nomegenero"];
                                                    echo "</a>";
                                                    echo "</td>";

                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <nav aria-label="Navegar por livros" class="mt-1">

                                            <ul class="pagination">
                                                <?php
                                                if (!isset($_GET["page"]) || ($_GET["page"] - 1) < 1) {
                                                    echo "
                                                        <li class='page-item disabled'>
                                                            <a class='page-link'>Previous</a>
                                                        </li>";
                                                } else {
                                                    $p = $_GET["page"] - 1;
                                                    echo "
                                                        <li class='page-item'>
                                                            <a href='/painel/generos/?page=$p' class='page-link'>Previous</a>
                                                        </li>";
                                                }

                                                for ($i = 1; $i <= $pages; $i++) {
                                                    if (isset($_GET["page"]) && $_GET["page"] == $i) {
                                                        echo "<li class='page-item active'><a class='page-link' href='/painel/generos/?page=$i'>$i</a></li>";
                                                    } else {
                                                        echo "<li class='page-item'><a class='page-link' href='/painel/generos/?page=$i'>$i</a></li>";
                                                    }
                                                }

                                                if ((!isset($_GET["page"]) && $pages == 1) || (isset($_GET["page"]) && $_GET["page"] == $pages)) {
                                                    echo "
                                                        <li class='page-item disabled'>
                                                            <a class='page-link'>Next</a>
                                                        </li>";
                                                } else if (!isset($_GET["page"]) && $pages > 1) {
                                                    echo "
                                                        <li class='page-item'>
                                                            <a href='/painel/generos/?page=2' class='page-link'>Next</a>
                                                        </li>";
                                                } else if (isset($_GET["page"]) && ($_GET["page"] + 1) <= $pages) {
                                                    $p = $_GET["page"] + 1;
                                                    echo "
                                                        <li class='page-item'>
                                                            <a href='/painel/generos/?page=$p' class='page-link'>Next</a>
                                                        </li>";
                                                }
                                                ?>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="card mt-2">
                                    <div class="card-header">
                                        criar Genero
                                    </div>
                                    <div class="card-body">
                                        <form class="row g-3" action="./" method="post">
                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                <label class="form-label" for="nome">Nome</label>
                                                <input placeholder="Exemple Name" class="form-control" id="nome" type="text" name="nome">
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                <button class="btn btn-success" type="submit">Cadastrar</button>
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                                <?php

                                                if ($resp != NULL) {
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
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="/static/js/scriptAluno.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
</body>

</html>