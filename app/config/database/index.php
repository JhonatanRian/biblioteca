<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	13/05/2023	Criado arquivo para referência de uso das funções de acesso ao banco.	  
******************************************************************************************************************
*/
	require 'TBibliotecaMC.php';
	require 'TLivrosMC.php';
	require 'TGenerosLiterariosMC.php';
	require 'TAlunosMC.php';
	require 'TEmprestimos_LivrosMC.php';
	$BibliotecaConnection  = new Biblioteca();
	$LivrosConnection      = new Livros();
	$GenerosConnection     = new Generos();
	$AlunosConnection      = new Alunos();
	$EmprestimosConnection = new Emprestimos();
	
	/*
	//Emprestimos ***********************************************************************
	//-----------------------------------------------------------------
	$StatusCadastro = $EmprestimosConnection->InsertEhUpdateEmprestimos("", 2, 1, 1, "2023-04-10", "2023-04-20", "");
	echo $StatusCadastro;
	//------------------------------------------------------------------	
	*/
	
	/*
	//Primeiro parametro, a consulta em si, segundo parametro o tipo de consulta, 
	//terceiro parametro se 1 retorna tambem os dias em atraso e as multas.
	//todos os parametros zerados retornam todos os registros
	//------------------------------------------------------------------
	$consultaEmprestimos = $EmprestimosConnection->GetInfoEmprestimos(0, 0, 0);
	if (!empty($consultaEmprestimos)) {
		foreach ($consultaEmprestimos as $emprestimos) {			

			echo $emprestimos["ordememprestimos"]."<br>";
			echo $emprestimos["idaluno"]."<br>";					
			echo $emprestimos["idlivro"]."<br>";
			echo $emprestimos["idoperador"]."<br>";
			echo $emprestimos["dataemprestimo"]."<br>";
			echo $emprestimos["dataprevistadevolucao"]."<br>";
			echo $emprestimos["datadadevolucao"]."<br>";
			echo $emprestimos["valordamulta"]."<br>";
			echo $emprestimos["diasatrasado"]."<br>";
			
		}
	}else {
		echo "Nenhum resultado encontrado.";
	}
	//------------------------------------------------------------------
	*/	
		
	
	/*
	//TBIBLIOTECA ***********************************************************************
	//-----------------------------------------------------------------
	$StatusCadastro = $BibliotecaConnection->InsertEhUpdateOperadores("", "NATHAN MASTER", 999);
	echo $StatusCadastro;
	//------------------------------------------------------------------	
	*/
	
	/*
	//------------------------------------------------------------------
	$consultaOperadores = $BibliotecaConnection->GetInfoOperadores(0, 0);
	if (!empty($consultaOperadores)) {
		foreach ($consultaOperadores as $operadores) {			

			echo $operadores["idoperador"]."<br>";
			echo $operadores["nomeoperador"]."<br>";					
			echo $operadores["niveldeacesso"]."<br>";
		}
	}else {
		echo "Nenhum resultado encontrado.";
	}
	//------------------------------------------------------------------
	*/
	
	
	//TLIVROS *********************************************************************************
	/*
	//Cadastra Livro e atualização de info livros
	//Obs.: Se deixar em branco o campo IDLIVRO é um cadastro de um novo
	//      Se deixar preenchido é a atualização das info de um livro, se n existir vai retorna na variavel a mensagem!
	//-----------------------------------------------------------------
	$StatusCadastro = $LivrosConnection->InsertEhUpdateLivros("", "LIVRO NOVO TESTANDO", "Eu mesmo 02", 5, 1, "blablabla02", true);
	echo $StatusCadastro;
	//------------------------------------------------------------------	
	*/	

	/*
	//Consulta Livro, segundo parametro tipo de consulta: 0 - PorID, 1- PorNome, 2 - porAutor, 3 - PorGenero 
	//Impressão dos Retornos da consulta de Livros, para buscar retorno de algo especifico deve 
	//passar a chave no $livro["CHAVE"] deve ser minuscula;
	//------------------------------------------------------------------
	$consultaLivros = $LivrosConnection->GetInfoLivros(0, 0);
	if (!empty($consultaLivros)) {
		foreach ($consultaLivros as $livro) {			

			echo $livro["idlivro"]."<br>";
			echo $livro["nomelivro"]."<br>";
			echo $livro["nomeautor"]."<br>";
			echo $livro["qtde"]."<br>";
			echo $livro["genero"]."<br>";
			echo $livro["sinopse"]."<br>";
			echo $livro["cadastroativo"]."<br>";
		}
	}else {
		echo "Nenhum resultado encontrado.";
	}
	//------------------------------------------------------------------
	*/
	
	/*
	//TGENEROSLITERARIOS ***************************************************************************
	
	//Cadastra Generos e atualização de info GENERO
	//Obs.: Se deixar em branco o campo IDGENERO é um cadastro de um novo
	//      Se deixar preenchido é a atualização das info de um GENERO, se n existir vai retorna na variavel a mensagem!
	//-----------------------------------------------------------------
	$StatusCadastro = $GenerosConnection->InsertEhUpdateGeneros("1", "GENERO TESTE");
	echo $StatusCadastro;
	//------------------------------------------------------------------	
	*/
	
    /*
	//Consulta Generos, segundo parametro tipo de consulta: 0 - PorID, 1- PorNome 
	//Impressão dos Retornos da consulta de Livros, para buscar retorno de algo especifico deve 
	//passar a chave no $livro["CHAVE"] deve ser minuscula;
	//------------------------------------------------------------------
	$consultaGeneros = $GenerosConnection->GetInfoGeneros(0, 0);
	if (!empty($consultaGeneros)) {
		foreach ($consultaGeneros as $generos) {		

			echo $generos["idgenero"]."<br>";
			echo $generos["nomegenero"]."<br>";
		}
	}else {
		echo "Nenhum resultado encontrado.";
	}
	//------------------------------------------------------------------
	*/
	
	
	/*
	//TALUNOS *********************************************************************************
	
	//Cadastra Livro e atualização de info livros
	//Obs.: Se deixar em branco o campo IDLIVRO é um cadastro de um novo
	//      Se deixar preenchido é a atualização das info de um livro, se n existir vai retorna na variavel a mensagem!
	//-----------------------------------------------------------------
	// Parametros: $prIdAluno, $prNomeAluno, $prCpfAluno, $prDataCadastro, $prExAluno, $prCurso, $prTurma, $prTelefone, $prCadastroAtivo	
	$StatusCadastro = $AlunosConnection->InsertEhUpdateAlunos("", "Aluno NOVO TESTANDO", "00099900099", "2023-05-01", 0, "ADS - Analise e desenvolimento de sistemas", "A-203", "47984080015", 1);
	echo $StatusCadastro;
	//------------------------------------------------------------------	
	*/	

	/*
	//Consulta Livro, segundo parametro tipo de consulta: 0 - PorID, 1- PorNome, 2 - PorCPF, 3 - PorCurso, 4 - PorTurma 
	//Impressão dos Retornos da consulta de Livros, para buscar retorno de algo especifico deve 
	//passar a chave no $livro["CHAVE"] deve ser minuscula;
	//------------------------------------------------------------------
	$consultaAlunos = $AlunosConnection->GetInfoAlunos(0, 0);
	if (!empty($consultaAlunos)) {
		foreach ($consultaAlunos as $alunos) {
			
			echo $alunos["idaluno"]."<br>";
			echo $alunos["nomealuno"]."<br>";
			echo $alunos["cpfaluno"]."<br>";						
			echo $alunos["datacadastro"]."<br>";						
			echo $alunos["exaluno"]."<br>";						
			echo $alunos["curso"]."<br>";						
			echo $alunos["turma"]."<br>";						
			echo $alunos["telefone"]."<br>";						
			echo $alunos["cadastroativo"]."<br>";
		}
	}else {
		echo "Nenhum resultado encontrado.";
	}
	//------------------------------------------------------------------
	*/
	
	
	
	
?>