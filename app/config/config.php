<?php

require_once "/app/config/database/TLivrosMC.php";
require_once "/app/config/database/TAlunosMC.php";
require_once "/app/config/database/TBibliotecaMC.php";
require_once "/app/config/database/TGenerosLiterariosMC.php";
require_once "/app/config/database/TEmprestimos_LivrosMC.php";

$EmprestimosLivrosQuery = new Emprestimos();
$LivrosQuery = new Livros();
$AlunosQuery = new Alunos();
$BibliotecaMCQuery = new Biblioteca();
$GeneroQuery = new Generos();

$CORESCAPAS = array();
$FONTESCAPAS = array(); 

?>