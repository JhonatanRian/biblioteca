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
    <title>Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/static/css/book.css">
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
        "id",
        "nome",
        "autor",
        "genero",
        "sinopse",
        "cad-ativo",
        "qtde",
        "corcapa",
        "fonte"
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
            $corcapa = $CORESCAPAS[$_POST["corcapa"]];
            $resp = $LivrosQuery->InsertEhUpdateLivros($_POST["id"], $_POST["nome"], 
                                                       $_POST["autor"], $_POST["genero"], 
                                                       $_POST["qtde"], $_POST["sinopse"], 
                                                       $cad, $corcapa, $_POST["fonte"]);
        }
    }
    ?>
    <main class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Atualização de dados
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-sm-12 col-md-6 col-lg-6 ">
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <?php
                                        if ($_GET["id_livro"]){
                                            $livro_id = $_GET["id_livro"];
                                            $livro = $LivrosQuery->GetInfoLivros($livro_id, 0);
                                            if ($livro){
                                                $livro = $livro[0];
                                                include "./form.php";
                                            }else {
                                                echo "<div class='alert alert-danger'>";
                                                echo "Livro não foi encontrado no sistema";
                                                echo "</div>";
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger'>";
                                            echo "Livro não selecionado";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-header">Livro</div>
                                    <div class="card-body">
                                        <?php
                                        if (isset($livro)){
                                            include "./livro.php";
                                        }
                                        ?>
                                        
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
    <script src="/static/js/scriptLivro.js"></script>
    <script src="/static/js/scriptGenero.js"></script>
    <script>
        pageret = "/painel/livros";
    </script>

</body>

</html>