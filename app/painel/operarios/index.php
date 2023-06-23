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
} elseif ($user["is_superuser"] == 0) {
    echo "Você não tem permissão para acessar essa pagina";
    exit;
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <?php
    if ($user["is_superuser"] and $user["is_staff"]) {
        include "/app/painel/header-admin.php";
    } else {
        include "/app/painel/header-op.php";
    }
    global $camposObrigatoriosOp;
    $camposObrigatoriosAluno = array(
        "nome",
        "senha",
        "cpf",
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($camposObrigatoriosAluno as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $resp = array(false, "O campo '$campo' é obrigatório.");
                break;
            }
        }
        if (isset($_POST["is_staff"])) {
            $staff = 1; // TRUE
        } else {
            $staff = 0; // FALSE
        }
        if (isset($_POST["is_superuser"])) {
            $superuser = 1;
        } else {
            $superuser = 0;
        }

        if ($staff == 0 and $superuser == 0) {
            $resp = array(false, "O usuario precisa ser dá equipe ou admin");
        }

        if (!isset($resp)) {
            $resp = $BibliotecaMCQuery->InsertEhUpdateOperadores("", $_POST["nome"], $_POST["cpf"], $_POST["senha"], $staff, $superuser);
        }
    }
    ?>
    <?php
    // Se não existir os parametros page, filter e search
    if ((!isset($_GET["filter"]) && !isset($_GET["search"])) && !isset($_GET["page"])) {
        $numOperarios = $BibliotecaMCQuery->CountOp("all", "");
        $pages = (int)($numOperarios / $ELEMPAGES) + 1;
        $operarios =  $BibliotecaMCQuery->GetOpPage($ELEMPAGES, 0);
    } else if (!isset($_GET["page"]) && isset($_GET["filter"]) && isset($_GET["search"])) { // se não existir o page, mas existir o filter e search 
        $filter = $_GET["filter"];
        $search = $_GET["search"];
        $numOperarios = $BibliotecaMCQuery->CountOp($filter, $search);
        $pages = (int)($numOperarios / $ELEMPAGES) + 1;
        $operarios = $BibliotecaMCQuery->GetOpPageFilter($ELEMPAGES, 0, $filter, $search);
    } else if (isset($_GET["page"]) && isset($_GET["filter"]) && isset($_GET["search"])) { // se existir o page e o filtro
        $page = $_GET["page"];
        $filter = $_GET["filter"];
        $search = $_GET["search"];
        $numOperarios = $BibliotecaMCQuery->CountOp($filter, $search);
        $pages = (int)($numOperarios / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $operarios = $BibliotecaMCQuery->GetOpPageFilter($ELEMPAGES, $offset, $filter, $search);
    } elseif (isset($_GET["page"]) && !isset($_GET["filter"]) && !isset($_GET["filter"])) { // se exitir somente o page
        $numOperarios = $BibliotecaMCQuery->CountOp("all", "");
        $page = $_GET["page"];
        $pages = (int)($numOperarios / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $operarios = $BibliotecaMCQuery->GetOpPage($ELEMPAGES, $offset);
    } else {
        $numOperarios = $BibliotecaMCQuery->CountOp("all", "");
        $pages = (int)($numOperarios / $ELEMPAGES) + 1;
        $operarios =  $BibliotecaMCQuery->GetOpPage($ELEMPAGES, 0);
    }

    ?>
    <main class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Operarios <?php
                        $BibliotecaMCQuery->GetOpPageFilter($ELEMPAGES, $offset, $filter, $search);
                        ?>
                    </div>
                    <div class="card-body">
                        <form action="." method="get">
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="radio" name="filter" value="nome" id="checkName" <?php
                                                                                                                                $check = $_GET["filter"] == "nome" ? "checked" : "";
                                                                                                                                if (strlen($check) == 0 && !isset($_POST["cpf"])) {
                                                                                                                                    $check = "checked";
                                                                                                                                }
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
                            </ul>
                            <div class="input-group">
                                <?php
                                $s = isset($_GET["search"]) ? $_GET["search"] : "";
                                $f = isset($_GET["filter"]) ? $_GET["filter"] : "nome";
                                $input = "<input class='form-control border border-primary' value='$s' type='search' name='search' id='search_op' placeholder='Buscar operario por $f'>";
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
                                        Operarios cadastrados
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">nome</th>
                                                    <th scope="col">cpf</th>
                                                    <th scope="col">equipe</th>
                                                    <th scope="col">admin</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($operarios as $op) {
                                                    $id_op = $op["idoperador"];
                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo "<a class='text-decoration-none' href='/painel/operarios/operario?id_op=$id_op'>";
                                                    echo $op["nomeoperador"];
                                                    echo "</a>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $op["cpf"];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    $check = $op["is_staff"] ? "
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                                                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                                                    </svg>
                                                    " : "
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'>
                                                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/>
                                                    </svg>
                                                    ";
                                                    echo $check;
                                                    echo "</td>";
                                                    echo "<td>";
                                                    $check = $op["is_superuser"] ? "
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-check-circle-fill' viewBox='0 0 16 16'>
                                                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z'/>
                                                    </svg>
                                                    " : "
                                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-x-circle-fill' viewBox='0 0 16 16'>
                                                        <path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/>
                                                    </svg>
                                                    ";
                                                    echo $check;
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
                                                $in_search = isset($search) ? "search=$search&" : "";
                                                $params = $in_filter . $in_search . "page=$previous_page";
                                                echo "<li class='page-item'>
                                                        <a href='/painel/livros/?$params' class='page-link'>Previous</a>
                                                    </li>";
                                            }

                                            for ($i = 1; $i <= $pages; $i++) {
                                                if ($i == $current_page) {
                                                    echo "<li class='page-item active'>
                                                            <a class='page-link'>$i</a>
                                                        </li>";
                                                } else {
                                                    $in_filter = isset($filter) ? "filter=$filter&" : "";
                                                    $in_search = isset($search) ? "search=$search&" : "";
                                                    $params = $in_filter . $in_search . "page=$i";
                                                    echo "<li class='page-item'>
                                                            <a href='/painel/livros/?$params' class='page-link'>$i</a>
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
                                                $in_search = isset($search) ? "search=$search&" : "";
                                                $params = $in_filter . $in_search . "page=$next_page";
                                                echo "<li class='page-item'>
                                                        <a href='/painel/livros/?$params' class='page-link'>Next</a>
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
                                        criar operario
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
                                                <label class="form-label" for="curso">senha</label>
                                                <input placeholder="senha" class="form-control" id="senha" type="password" name="senha">
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <input type="checkbox" class="form-check-input" name="is_staff" id="is_staff">
                                                <label class="form-check-label" for="is_staff">é da equipe?</label>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <input type="checkbox" class="form-check-input" name="is_superuser" id="is_superuser">
                                                <label class="form-check-label" for="is_admin">é admin?</label>
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
        const inputSearch = document.querySelector("#search_op");
        console.log(inputSearch)
        Array.from(inputsCheck).forEach((elem, index) => {
            elem.addEventListener("change", (event) => {
                let label = LabelsCheck[index];
                inputSearch.setAttribute("placeholder", `Buscar aluno por ${label.textContent}`)
            })
        })
    </script>
</body>

</html>