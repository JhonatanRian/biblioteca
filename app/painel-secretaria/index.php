<!doctype html>
<html lang="pt-br">

<?php
require '../config/database/TAlunosMC.php';
require '../config/database/TEmprestimos_LivrosMC.php';
$AlunosConnection      = new Alunos();
$EmprestimosConnection = new Emprestimos();
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../static/css/styles.css">
</head>

<body>
    <header class="site-header sticky-top py-1 text-bg-dark">
        <nav class="container d-flex flex-column flex-md-row justify-content-between">
            <a class="py-2" href="#" aria-label="Product">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" viewBox="0 0 460 460" xml:space="preserve" width="44" height="44" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="d-block mx-auto" role="img" viewBox="0 0 24 24">
                    <title>
                        Biblioteca
                    </title>
                    <circle cx="12" cy="12" r="10"></circle>
                    <g id="XMLID_844_">
                        <path id="XMLID_1068_" style="fill:#695538;" d="M110,435H60l-10-30h70L110,435z M410,405h-70l10,30h50L410,405z" />
                        <path id="XMLID_843_" style="fill:#CBB57A;" d="M460,415H0v-40h460V415z" />
                        <path id="XMLID_842_" style="fill:#9E8E60;" d="M460,425H0v-20h460V425z" />
                        <path id="XMLID_1783_" style="fill:#D66A40;" d="M200,105v280c0,5.523-4.477,10-10,10h-50c-5.523,0-10-4.477-10-10   c0,5.523-4.477,10-10,10H70c-5.523,0-10-4.477-10-10V35c0-5.523,4.477-10,10-10h50c5.523,0,10,4.477,10,10v70   c0-5.523,4.477-10,10-10h50C195.523,95,200,99.477,200,105z M419.751,350.584L259.15,121.222   c-3.168-4.524-9.403-5.624-13.927-2.456l-40.958,28.679c-4.524,3.168-5.624,9.403-2.456,13.927l160.601,229.363   c3.168,4.524,9.403,5.624,13.927,2.456l40.958-28.679C421.82,361.344,422.919,355.109,419.751,350.584z" />
                        <path id="XMLID_1778_" style="fill:#B14724;" d="M200,235H60V135h140V235z M200,295H60v30h140V295z" />
                        <path id="XMLID_1782_" style="fill:#732D21;" d="M259.15,121.222l160.601,229.363c3.168,4.524,2.068,10.759-2.456,13.927   l-40.958,28.679c-4.524,3.168-10.759,2.068-13.927-2.456L201.809,161.372c-3.168-4.524-2.068-10.76,2.456-13.927l40.958-28.679   C249.747,115.598,255.982,116.698,259.15,121.222z" />
                        <path id="XMLID_1781_" style="fill:#C18F2B;" d="M287.829,162.18l-57.341,40.15l-17.207-24.575l57.341-40.15L287.829,162.18z    M310.772,194.946l-57.341,40.15l74.565,106.49l57.341-40.15L310.772,194.946z" />
                        <path id="XMLID_1780_" style="fill:#64757C;" d="M130,35v350c0,5.523-4.477,10-10,10H70c-5.523,0-10-4.477-10-10V35   c0-5.523,4.477-10,10-10h50C125.523,25,130,29.477,130,35z" />
                        <path id="XMLID_1779_" style="fill:#374145;" d="M130,295H60V145h70V295z M130,95H60v20h70V95z M130,325H60v20h70V325z" />
                    </g>
                </svg>
            </a>
            <a class="py-2 d-none d-md-inline-block" href="./livros/">
                <button class="btn btn-secondary active">
                    Adicionar livro
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block" href="./generos/">
                <button class="btn btn-secondary">
                    Adicionar genero
                </button>
            </a>
            <a class="py-2 d-none d-md-inline-block" href="./alunos/">
                <button class="btn btn-secondary">
                    Adicionar aluno
                </button>
            </a>
            <span class="py-2 d-none d-md-inline-block">
                <span class="py-2 d-none d-md-inline-block" aria-current="page" href="#">Bem vindo(a) <span class="text-primary">Valeria</span></span>
            </span>
        </nav>
    </header>
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
                                $consultaEmprestimos = $EmprestimosConnection->GetInfoEmprestimos(0, 4);
                                if (!empty($consultaEmprestimos)) {
                                    foreach ($consultaEmprestimos as $emprestimos) {
                                        if ($emprestimos["qtde"] == 3){
                                            echo "<tr class='table-danger'>";
                                        } else if ($emprestimos["qtde"] == 2){
                                            echo "<tr class='table-warning'>";
                                        } else{
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
                            $n = $_GET["name_aluno"];

                            if ($n){
                                $consultaAlunos = $AlunosConnection->GetInfoAlunos($n, 1);
                                if (!empty($consultaAlunos)) {
                                    echo "<ul class='list-group list-group-flush' >";

                                    foreach ($consultaAlunos as $alunos) {

                                        // echo $alunos["idaluno"] . "<br>";
                                        
                                        echo "<a href='../alugar?id_aluno=".$alunos["idaluno"]."' class='list-group-item list-group-item-action' >";
                                        echo $alunos["nomealuno"]." - ".$alunos["cpfaluno"];
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
                        <ul class="dropdown-menu">

                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
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