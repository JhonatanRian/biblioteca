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
    <title>Genero</title>
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
        "id",
        "nome",
    );
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($camposObrigatoriosAluno as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                $resp = array(false, "O campo '$campo' é obrigatório.");
                break;
            }
        }
        if (!isset($resp)){
            $resp = $GeneroQuery->InsertEhUpdateGeneros($_POST["id"], $_POST["nome"]);
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
                            <div class="col-sm-12 col-md-6 col-lg-6 m-auto">
                                <div class="card mt-2">
                                    <div class="card-body">
                                        <?php
                                        if ($_GET["id_genero"]){
                                            $genero_id = $_GET["id_genero"];
                                            $genero = $GeneroQuery->GetInfoGeneros($genero_id, 0);
                                            if ($genero){
                                                $genero = $genero[0];
                                                include "./form.php";
                                            }else {
                                                echo "<div class='alert alert-danger'>";
                                                echo "Genero não foi encontrado no sistema";
                                                echo "</div>";
                                            }
                                        } else {
                                            echo "<div class='alert alert-danger'>";
                                            echo "Genero não selecionado";
                                            echo "</div>";
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
    <script src="/static/js/scriptGenero.js"></script>
</body>

</html>