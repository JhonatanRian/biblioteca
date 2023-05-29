<?php
require "../config/database/TEmprestimos_LivrosMC.php";

$EmprestimosLivros = new Emprestimos();

global $camposObrigatorios;
$camposObrigatorios = array(
    "livro",
    "idaluno"
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



?>