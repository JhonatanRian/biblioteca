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

$CORESCAPAS = array(
    "book-brown"=>"book-brown",
    "book-navy-blue"=>"book-navy-blue",
    "book-purple"=>"book-purple",
    "book-cola"=>"book-cola",
    "book-yelow"=>"book-yelow",
    "book-green"=>"book-green"
);
$FONTESCAPAS = array("book-text-rajd" => "book-text-rajd", 
                     "book-text-dacing" => "book-text-dacing", 
                     "book-text-nunito" => "book-text-nunito",
                     "book-text-pacific" => "book-text-pacific"); 

$ELEMPAGES = 10;

?>