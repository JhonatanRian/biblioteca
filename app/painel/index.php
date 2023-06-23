<?php
require_once '/app/config/authenticate.php';
require_once '/app/config/config.php';

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
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/css/styles.css">
</head>

<body class="">
    <?php
    if ($user["is_superuser"] and $user["is_staff"]) {
        include "./header-admin.php";
    } else {
        include "./header-op.php";
    }
    ?>
    <main class="container">
        <br>
        <div class="row">
            <div class="col-sm-12 col-md-8 col-sm-8">
                <div class="card text-center">
                    <div class="card-title">
                        <h5>
                            Alugueis
                        </h5>
                    </div>
                    <div class="table-container">
                        <table class="table table-primary table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Nome do Aluno</th>
                                    <th scope="col">Telefone</th>
                                    <th scope="col">Quantidade de livros</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $consultaEmprestimos = $EmprestimosLivrosQuery->GetInfoEmprestimos(0, 4);
                                if (!empty($consultaEmprestimos)) {
                                    foreach ($consultaEmprestimos as $emprestimos) {
                                        if ($emprestimos["qtde"] >= 3) {
                                            echo "<tr class='table-danger'>";
                                        } else if ($emprestimos["qtde"] == 2) {
                                            echo "<tr class='table-warning'>";
                                        } else {
                                            echo "<tr>";
                                        }
                                        echo "<th scope='row'>" . $emprestimos["nomealuno"] . "</th>";
                                        echo "<td>" . $emprestimos["telefone"] . "</td>";
                                        echo "<td>" . $emprestimos["qtde"] . "</td>";
                                        // echo $emprestimos["ordememprestimos"] . "<br>";
                                        // echo $emprestimos["idlivro"] . "<br>";
                                        // echo $emprestimos["idoperador"] . "<br>";
                                        // echo $emprestimos["dataemprestimo"] . "<br>";
                                        // echo $emprestimos["dataprevistadevolucao"] . "<br>";
                                        // echo $emprestimos["datadadevolucao"] . "<br>";
                                        // echo $emprestimos["valordamulta"] . "<br>";
                                        // echo $emprestimos["diasatrasado"] . "<br>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<td colspan=4 > Nenhum resultado encontrado. </td>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-sm-4">
                <div class="card text-center">
                    <div class="card-title">
                        <h5>
                            Alugar para um aluno
                        </h5>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" action="./" method="GET">
                            <div class="col-auto">
                                <label for="staticEmail2" class="visually-hidden">Email</label>
                                <input name="name_aluno" class="form-control" placeholder="busca aluno...">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-3">buscar</button>
                            </div>
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET") {
                            if (isset($_GET["name_aluno"])) {
                                 $n = $_GET["name_aluno"];
                                $consultaAlunos = $AlunosQuery->GetInfoAlunos($n, 1);
                                if (!empty($consultaAlunos)) {
                                    echo "<ul class='list-group list-group-flush' >";

                                    foreach ($consultaAlunos as $alunos) {

                                        // echo $alunos["idaluno"] . "<br>";

                                        echo "<a href='./alugar?id_aluno=" . $alunos["idaluno"] . "' class='list-group-item list-group-item-action' >";
                                        echo $alunos["nomealuno"] . " - " . $alunos["cpfaluno"];
                                        echo "</a>";
                                        // echo $alunos["datacadastro"] . "<br>";
                                        // echo $alunos["exaluno"] . "<br>";
                                        // echo $alunos["curso"] . "<br>";
                                        // echo $alunos["turma"] . "<br>";
                                        // echo $alunos["telefone"] . "<br>";
                                        // echo $alunos["cadastroativo"] . "<br>";

                                    }
                                    echo "</ul>";
                                } else {
                                    echo "Nenhum resultado encontrado.";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="container">
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
            <div class="col-md-4 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                </a>
                <span class="mb-3 mb-md-0 text-muted">© 2022 Company, Inc</span>
            </div>

            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                            <use xlink:href="#twitter"></use>
                        </svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                            <use xlink:href="#instagram"></use>
                        </svg></a></li>
                <li class="ms-3"><a class="text-muted" href="#"><svg class="bi" width="24" height="24">
                            <use xlink:href="#facebook"></use>
                        </svg></a></li>
            </ul>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>