<?php
require '../config/database/TLivrosMC.php';
$LivrosConnection      = new Livros();

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nome_livro = $_GET["nome_livro"];

    if ($nome_livro) {
        $consultaLivros = $LivrosConnection->GetInfoLivros($nome_livro, 1);
        if (!empty($consultaLivros)) {
            $resp = array();

            foreach ($consultaLivros as $livro) {
                $livro_resp = array(
                    "id" => $livro["idlivro"],
                    "nome" => $livro["nomelivro"],
                    "nome_autor" => $livro["nomeautor"],
                    "qtde" => $livro["qtde"],
                    "genero" => $livro["genero"],
                    "sinopse" => $livro["sinopse"],
                    "cadastroativo" => $livro["cadastroativo"]

                );
                array_push($resp, $livro_resp);
            }
            header('Content-Type: application/json');
            echo json_encode($resp);
        } else {
            echo "Nenhum resultado encontrado.";
        }
    }
}


?>