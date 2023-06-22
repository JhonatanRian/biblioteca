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
    global $camposObrigatoriosAluno;
    $camposObrigatoriosAluno = array(
        "nome",
        "autor",
        "genero",
        "sinopse",
        "cad-ativo",
        "qtde",
    );

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($camposObrigatoriosAluno as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $resp = array(false, "O campo '$campo' é obrigatório.");
                break;
            }
        }
        if (isset($_POST["cad-ativo"])) {
            $cad = 1;
        } else {
            $cad = 0;
        }
        if (!isset($resp)) {
            $resp = $LivrosQuery->InsertEhUpdateLivros("", $_POST["nome"], $_POST["autor"], $_POST["genero"], $_POST["qtde"], $_POST["sinopse"], $cad);
        }
    }
    ?>
    <?php
    if ((!isset($_GET["filter"]) && !isset($_GET["search"])) && !isset($_GET["page"])) {
        $numLivros = $LivrosQuery->CountLivros("all", "");
        $pages = (int)($numLivros / $ELEMPAGES) + 1;
        $livros =  $LivrosQuery->GetLivrosPage($ELEMPAGES, 0);
    } else if (!isset($_GET["page"]) && isset($_GET["filter"]) && isset($_GET["search"])) { // se não existir o page, mas existir o filter e search 
        $filter = $_GET["filter"];
        $search = $_GET["search"];
        $numLivros = $LivrosQuery->CountLivros($filter, $search);
        $pages = (int)($numLivros / $ELEMPAGES) + 1;
        $livros = $LivrosQuery->GetLivrosPageFilter($ELEMPAGES, 0, $filter, $search);
    } else if (isset($_GET["page"]) && isset($_GET["filter"]) && isset($_GET["search"])) { // se existir o page e o filtro
        $page = $_GET["page"];
        $filter = $_GET["filter"];
        $search = $_GET["search"];
        $numLivros = $LivrosQuery->CountLivros($filter, $search);
        $pages = (int)($numLivros / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $livros = $LivrosQuery->GetLivrosPageFilter($ELEMPAGES, $offset, $filter, $search);
    } elseif (isset($_GET["page"]) && !isset($_GET["filter"]) && !isset($_GET["filter"])) { // se exitir somente o page
        $numLivros = $LivrosQuery->CountLivros("all", "");
        $page = $_GET["page"];
        $pages = (int)($numLivros / $ELEMPAGES) + 1;
        $offset = ($page - 1) * $ELEMPAGES;
        $livros = $LivrosQuery->GetLivrosPage($ELEMPAGES, $offset);
    } else {
        $numLivros = $LivrosQuery->CountLivros("all", "");
        $pages = (int)($numLivros / $ELEMPAGES) + 1;
        $livros =  $LivrosQuery->GetLivrosPage($ELEMPAGES, 0);
    }
    ?>
    <main class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Livros 
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
                                    <input class="form-check-input me-1" type="radio" name="filter" value="genero" id="checkCpf" <?php
                                    $check = $_GET["filter"] == "genero" ? "checked" : "";
                                    echo $check;
                                    ?>>
                                    <label class="form-check-label" for="checkCpf">genero</label>
                                </li>
                                <li class="list-group-item">
                                    <input class="form-check-input me-1" type="radio" name="filter" value="autor" id="checkCurso" <?php
                                    $check = $_GET["filter"] == "autor" ? "checked" : "";
                                    echo $check;
                                    ?>>
                                    <label class="form-check-label" for="checkCurso">autor</label>
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
                                        livros cadastrados
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">nome</th>
                                                    <th scope="col">genero</th>
                                                    <th scope="col">quantidade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($livros as $livro) {
                                                    $id_livro = $livro["idlivro"];
                                                    echo "<tr>";
                                                    echo "<td>";
                                                    echo "<a class='text-decoration-none' href='/painel/livros/livro?id_livro=$id_livro'>";
                                                    echo $livro["nomelivro"];
                                                    echo "</a>";
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $livro["nomegenero"];
                                                    echo "</td>";
                                                    echo "<td>";
                                                    echo $livro["qtde"];
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
                                                    $in_search = isset($search) ? "search=$search&": "";
                                                    $params = $in_filter.$in_search."page=$i";
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
                                                $in_search = isset($search) ? "search=$search&": "";
                                                $params = $in_filter.$in_search."page=$next_page";
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
                                        criar Livro
                                    </div>
                                    <div class="card-body">
                                        <form class="row g-3" action="./" method="post">
                                            <div class="col-sm-12 col-md-12 col-lg-6">
                                                <label class="form-label" for="nome">Nome</label>
                                                <input placeholder="Exemple Name" class="form-control" id="nome" type="text" name="nome">
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label class="form-label" for="autor">Nome do Autor</label>
                                                <input placeholder="Nome do Autor" class="form-control" id="autor" type="text" name="autor">
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <div class="form-floating">
                                                    <select name="genero" class="form-select" id="genero" aria-label="Generos literarios">
                                                        <?php
                                                        $generos = $GeneroQuery->GetInfoGeneros(0, 0);
                                                        foreach ($generos as $genero) {
                                                            $id_genero = $genero["idgenero"];
                                                            $nome_genero = $genero["nomegenero"];
                                                            echo "<option value='$id_genero'>$nome_genero</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <label for="floatingSelect">Genero Literario:</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <input placeholder="Quantidade de Livros" class="form-control" id="qtde" type="number" name="qtde">
                                            </div>
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <div class="form-floating">
                                                    <textarea name="sinopse" class="form-control" placeholder="Sobre o Livro" id="sinopse"></textarea>
                                                    <label for="sinopse">Sinopse</label>
                                                </div>
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
    <script>
        const inputsCheck = document.querySelectorAll("body > main > div > div > div > div.card-body > form > ul input");
        const LabelsCheck = document.querySelectorAll("body > main > div > div > div > div.card-body > form > ul label");
        const inputSearch = document.querySelector("#search_livro");

        Array.from(inputsCheck).forEach((elem, index) => {
            elem.addEventListener("change", (event) => {
                let label = LabelsCheck[index];
                inputSearch.setAttribute("placeholder", `Buscar livro por ${label.textContent}`)
            })
        })
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
</body>

</html>