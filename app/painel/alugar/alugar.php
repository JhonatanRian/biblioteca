<?php
require_once "/app/config/authenticate.php";


global $camposObrigatorios;
$camposObrigatorios = array(
    "livro",
    "idaluno",
    "data"
);

function VerificarCampos()
{
    global $camposObrigatorios;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        foreach ($camposObrigatorios as $campo) {
            if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                echo "<div class='alert alert-danger'>";
                echo "O campo '$campo' é obrigatório.";
                echo "</div>";
                return false;
            }
        }
        return true;
    }
}

function SalvarAluguel()
{
    require "/app/config/config.php";

    $id_aluno = $_POST["idaluno"];
    $id_livro = $_POST["livro"];
    $id_op = $_SESSION["id"];
    $dataprev = $_POST["data"];
    $dataAtual = date("d/m/Y");
    $dataBanco = date("Y/m/d", strtotime($dataAtual));
    
    return $EmprestimosLivrosQuery->InsertEmprestimos($id_aluno, $id_livro, $id_op, $dataBanco, $dataprev, $dataprev);

}

?>