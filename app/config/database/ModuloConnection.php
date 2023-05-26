<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	13/05/2023	Criado o módulo connection para interação com o banco.	  
******************************************************************************************************************
*/
	
	$servername = "localhost";
	$username = "root";
	$password = "";
	$basename = "sdbbiblio";

	// Cria conexao com a base - Para ser chamado em outros fontes...
	$connection = new mysqli($servername, $username, $password, $basename);
	
	if ($connection->connect_error) {
		die("Erro de conexão com o banco: $Erro -> " . $connection->connect_error);
	}
	
	
?>