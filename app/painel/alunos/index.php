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
    <title>Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    if ($user["is_superuser"] and $user["is_staff"]) {
        include "/app/painel/header-admin.php";
    } else {
        include "/app/painel/header-op.php";
    }
    global $camposObrigatoriosAluno;
    $camposObrigatoriosAluno = array(
        "nome",
        "cpf",
        "contato",
        "curso",
        "turma",
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($camposObrigatoriosAluno as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $resp = array(false, "O campo '$campo' é obrigatório.");
                break;
            }
        }
        if (isset($_POST["ex-aluno"])) {
            $exAluno = 1; // TRUE
        } else {
            $exAluno = 0; // FALSE
        }
        if (isset($_POST["cad-ativo"])) {
            $cad = 1;
        } else {
            $cad = 0;
        }
        if (!isset($resp)) {
            $resp = $AlunosQuery->InsertEhUpdateAlunos("", $_POST["nome"], $_POST["cpf"], $exAluno, $_POST["curso"], $_POST["turma"], $_POST["contato"], $cad);
        }
    }
    ?>
    <?php
    // Se não existir os parametros page, filter e search
    if ((!isset($_GET["filter"]) && !isset($_GET["search"])) && !isset($_GET["page"])) {
        $numAlunos = $AlunosQuery->CountAlunos("all", "");
        $pages = (int)($numAlunos / $ELEMPAGES) + 1;
        $alunos =  $AlunosQuery->GetAlunosPage($ELEMPAGES, 0);
    } else if (!isset($_GET["page"]) && isset($_GET["filter"]) && isset($_GET["search"])) { // se não existir o page, mas existir o filter e search 
        $filter = $_GET["filter"];
        $search = $_GET["search"];
        $numAlunos = $AlunosQuery->CountAlunos($filter, $search); ;
        $pages = (int)($numAlunos / $ELEMPAGES) + 1;
        $alunos = $AlunosQuery->GetAlunosPageFilter($ELEMPAGES, 0, $filter, $search);
    } else if (isset($_GET["page"]) && isset($_GET["filter"]) && isset($_GET["search"])) { // se existir o page e o filtro
        $page = $_GET["page"];
        $filter = $_GET["filter"];
        $search = $_GET["search"];
        $numAlunos = $AlunosQuery->CountAlunos($filter, $search);
        $pages = (int)($numAlunos / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $alunos = $AlunosQuery->GetAlunosPageFilter($ELEMPAGES, $offset, $filter, $search);
    } elseif (isset($_GET["page"]) && !isset($_GET["filter"]) && !isset($_GET["filter"])) { // se exitir somente o page
        $numAlunos = $AlunosQuery->CountAlunos("all", "");
        $page = $_GET["page"];
        $pages = (int)($numAlunos / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $alunos = $AlunosQuery->GetAlunosPage($ELEMPAGES, $offset);
    } else {
        $numAlunos = $AlunosQuery->CountAlunos("all", "");
        $pages = (int)($numAlunos / $ELEMPAGES) + 1;
        $alunos =  $AlunosQuery->GetAlunosPage($ELEMPAGES, 0);
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
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="radio" name="filter" value="nome" id="checkName" <?php
                                    $check = $_GET["filter"] == "nome" ? "checked" : "";
                                    echo $check;
                                    ?>>
                                    <label class="form-check-label" for="checkName">Nome</label>
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="radio" name="filter" value="cpf" id="checkCpf" <?php
                                    $check = $_GET["filter"] == "cpf" ? "checked" : "";
                                    echo $check;
                                    ?>>
                                    <label class="form-check-label" for="checkCpf">cpf</label>
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="radio" name="filter" value="curso" id="checkCurso" <?php
                                    $check = $_GET["filter"] == "curso" ? "checked" : "";
                                    echo $check;
                                    ?>>
                                    <label class="form-check-label" for="checkCurso">curso</label>
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="radio" name="filter" value="turma" id="checkTurma" <?php
                                    $check = $_GET["filter"] == "turma" ? "checked" : "";
                                    echo $check;
                                    ?>>
                                    <label class="form-check-label" for="checkTurma">turma</label>
                                </li>
                            </ul>
                            <div class="input-group">
                                <?php
                                $s = isset($_GET["search"]) ? $_GET["search"] : "";
                                $f = isset($_GET["filter"]) ? $_GET["filter"] : "nome";
                                $input = "<input class='form-control border border-primary' value='$s' type='search' name='search' id='search_livro' placeholder='Buscar livro por $f'>";
                                echo $input;
                                ?>
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
                                                    <th scope="col">nome</th>
                                                    <th scope="col">cpf</th>
                                                    <th scope="col">turma</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($alunos as $aluno) {
                                                    $id_aluno = $aluno["idaluno"];
                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo "<a class='text-decoration-none' href='/painel/alunos/aluno?id_aluno=$id_aluno'>";
                                                    echo $aluno["nomealuno"];
                                                    echo "</a>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $aluno["cpfaluno"];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $aluno["turma"];
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                        <nav aria-label="Navegar por livros" class="mt-1">

                                            <?php
                                            $current_page = isset($_GET["page"]) ? $_GET["page"] : 1;

                                            echo "<ul class='pagination'>";

                                            if ($current_page == 1) {
                                                echo "<li class='page-item disabled'>
                                                        <a class='page-link'>Previous</a>
                                                    </li>";
                                            } else {
                                                $previous_page = $current_page - 1;
                                                $in_filter = isset($filter) ? "filter=$filter&" : "";
                                                $in_search = isset($search) ? "search=$search&": "";
                                                $params = $in_filter.$in_search."page=$previous_page";
                                                echo "<li class='page-item'>
                                                        <a href='/painel/alunos/?$params' class='page-link'>Previous</a>
                                                    </li>";
                                            }

                                            for ($i = 1; $i <= $pages; $i++) {
                                                if ($i == $current_page) {
                                                    echo "<li class='page-item active'>
                                                            <a class='page-link'>$i</a>
                                                        </li>";
                                                } else {
                                                    $in_filter = isset($filter) ? "filter=$filter&" : "";
                                                    $in_search = isset($search) ? "search=$search&": "";
                                                    $params = $in_filter.$in_search."page=$i";
                                                    echo "<li class='page-item'>
                                                            <a href='/painel/alunos/?$params' class='page-link'>$i</a>
                                                        </li>";
                                                }
                                            }

                                            if ($current_page == $pages) {
                                                echo "<li class='page-item disabled'>
                                                        <a class='page-link'>Next</a>
                                                    </li>";
                                            } else {
                                                $next_page = $current_page + 1;
                                                $in_filter = isset($filter) ? "filter=$filter&" : "";
                                                $in_search = isset($search) ? "search=$search&": "";
                                                $params = $in_filter.$in_search."page=$next_page";
                                                echo "<li class='page-item'>
                                                        <a href='/painel/alunos/?$params' class='page-link'>Next</a>
                                                    </li>";
                                            }

                                            echo "</ul>";
                                            ?>
                                        </nav>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="card mt-2">
                                    <div class="card-header">
                                        criar aluno
                                    </div>
                                    <div class="card-body">
                                        <form class="row g-3" action="./" method="post">
                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                <label class="form-label" for="nome">Nome</label>
                                                <input placeholder="Exemple Name" class="form-control" id="nome" type="text" name="nome">
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label" for="cpf">cpf</label>
                                                <input placeholder="999.999.999-99" class="form-control" id="cpf" type="text" name="cpf">
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label class="form-label" for="contato">contato</label>
                                                <input placeholder="+55 (99) 99999-9999" class="form-control" id="contato" type="tel" name="contato">
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label class="form-label" for="curso">curso</label>
                                                <input placeholder="Nome do curso" class="form-control" id="curso" type="text" name="curso">
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label class="form-label" for="turma">turma</label>
                                                <input placeholder="Turma" class="form-control" id="turma" type="text" name="turma">
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <input type="checkbox" class="form-check-input" value="" name="ex-aluno" id="ex-aluno">
                                                <label class="form-check-label" for="ex-aluno">ex-aluno</label>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <input type="checkbox" class="form-check-input" name="cad-ativo" id="cad-ativo">
                                                <label class="form-check-label" for="cad-ativo">cadastro ativo?</label>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
        $(document).ready(function() {
            $('#cpf').mask('000.000.000-00');
            $('#contato').mask('+55 (99) 99999-9999');

            $('#cpf').on('keypress', function(event) {
                var tecla = event.which || event.keyCode;
                if (tecla < 48 || tecla > 57) {
                    event.preventDefault();
                }
            });

            $('#contato').on('keypress', function(event) {
                var tecla = event.which || event.keyCode;
                if (tecla < 48 || tecla > 57) {
                    event.preventDefault();
                }
            });
        });
        const inputsCheck = document.querySelectorAll("body > main > div > div > div > div.card-body > form > ul input");
        const LabelsCheck = document.querySelectorAll("body > main > div > div > div > div.card-body > form > ul label");
        const inputSearch = document.querySelector("#search_aluno");

        Array.from(inputsCheck).forEach((elem, index) => {
            elem.addEventListener("change", (event) => {
                let label = LabelsCheck[index];
                inputSearch.setAttribute("placeholder", `Buscar aluno por ${label.textContent}`)
            })
        })
    </script>
</body>

</html>