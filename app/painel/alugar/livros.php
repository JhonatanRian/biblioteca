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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $nome_livro = $_GET["nome_livro"];

    if ($nome_livro) {
        $consultaLivros = $LivrosQuery->GetInfoLivros($nome_livro, 1);
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