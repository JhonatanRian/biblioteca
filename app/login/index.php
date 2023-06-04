<?php
session_start();
require_once '/app/config/config.php';

if (isset($_SESSION) and isset($_SESSION["id"])) {
    header("Location: /");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body class="container">
    <br>
    <main class="row form-signin w-100 m-auto">

        <form class="col-sm-12 col-md-4 col-lg-4 m-auto text-center" action="" method="POST">
            <img class="mb-4" src="../static/img/pilha-de-livros.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="text" class="form-control" id="CPF" placeholder="999.999.999-99" name="cpf">
                <label for="floatingInput">CPF</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" id="SENHA" placeholder="Sua senha" name="senha">
                <label for="floatingPassword">SENHA</label>
            </div>
            <br>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">© 2017–2022</p>
            <div>
                <?php
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if ((isset($_POST["cpf"]) && $_POST["cpf"] == "") || (!isset($_POST["senha"]) && $_POST["senha"] == "")) {
                        echo "<div class='alert alert-danger'>";
                        echo "Preencha todos os campos!";
                        echo "</div>";
                    } else {
                        $cpf = $_POST["cpf"];
                        $senha = $_POST["senha"];
                        $operador = $BibliotecaMCQuery->VerificarLogin($cpf, $senha);
                        if ($operador === false) {
                            echo "<div class='alert alert-danger'>";
                            echo "CPF OU SENHA INCORRETOS!";
                            echo "</div>";
                        } else {
                            $_SESSION["id"] = $operador["IDOPERADOR"];
                            $_SESSION["nome"] = $operador["NOMEOPERADOR"];
                            header("Location: /painel/");
                            exit;
                        }
                    }
                }
                ?>
            </div>
        </form>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
    <script>
        $(document).ready(function() {
            var $seuCampoCpf = $("#CPF");
            $('#CPF').mask('000.000.000-00');
        });
    </script>
</body>

</html>