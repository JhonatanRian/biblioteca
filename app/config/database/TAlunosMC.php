<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	15/05/2023	Criado funções de manipulação da tabela TALUNOS.	  
******************************************************************************************************************
*/

require_once 'ModuloConnection.php';

class Alunos
{
	private $connection;

	public function __construct()
	{
		global $servername, $username, $password, $basename;
		$this->connection = new mysqli($servername, $username, $password, $basename);
		if ($this->connection->connect_error) {
			die("Erro de conexão com o banco: " . $this->connection->connect_error);
		}
		//else {
		//	echo "Conexão estabelecida com exito!";	
		//}
	}

	public function GetInfoAlunos($prInfoConsulta, $prTipoConsulta)
	{
		$retornoConsulta = array();
		$ConsultaGeral   = false;
		$filtro          = "";

		if (($prInfoConsulta == 0) and ($prTipoConsulta == 0)) {
			$ConsultaGeral = true;
		}

		// Consulta por ID do ALUNO
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDALUNO = $prInfoConsulta";
		} // Consulta por NOMEALUNO 
		else if (($prTipoConsulta == 1) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(NOMEALUNO), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		} // Consulta por CPFALUNO 
		else if (($prTipoConsulta == 2) and ($ConsultaGeral == false)) {
			$filtro = " WHERE CPFALUNO = '$prInfoConsulta'";
		} // Consulta por CURSO 
		else if (($prTipoConsulta == 3) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(CURSO), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		} // Consulta por TURMA
		else if (($prTipoConsulta == 4) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(TURMA), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}

		$sql = "SELECT * FROM TALUNOS " . $filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idaluno"       => $row["IDALUNO"],
					"nomealuno"     => $row["NOMEALUNO"],
					"cpfaluno"      => $row["CPFALUNO"],
					"datacadastro"  => $row["DATACADASTRO"],
					"exaluno"       => $row["EXALUNO"],
					"curso"         => $row["CURSO"],
					"turma"         => $row["TURMA"],
					"telefone"      => $row["TELEFONE"],
					"cadastroativo" => $row["CADASTROATIVO"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function InsertEhUpdateAlunos($prIdAluno, $prNomeAluno, $prCpfAluno, $prExAluno, $prCurso, $prTurma, $prTelefone, $prCadastroAtivo)
	{
		$dataAtual = date("Y-m-d");
		if (!empty(trim($prIdAluno))) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}

		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TALUNOS WHERE IDALUNO = ?";
			$stmtAux = $this->connection->prepare($sqlAux);
			$stmtAux->bind_param("s", $prIdAluno);
			$stmtAux->execute();
			$resultadoSqlAux = $stmtAux->get_result();

			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TALUNOS SET NOMEALUNO = ?, CPFALUNO = ?, DATACADASTRO = ?," .
					" EXALUNO = ?, CURSO = ?, TURMA = ?, TELEFONE = ?," .
					" CADASTROATIVO = ? WHERE IDALUNO = ?";
				$stmtCad = $this->connection->prepare($sqlCad);
				$stmtCad->bind_param(
					"ssssssssi",
					$prNomeAluno,
					$prCpfAluno,
					$dataAtual,
					$prExAluno,
					$prCurso,
					$prTurma,
					$prTelefone,
					$prCadastroAtivo,
					$prIdAluno
				);
				$retornoSqlCad = $stmtCad->execute();

				if ($retornoSqlCad) {
					return array(true, "Dados atualizados com sucesso");
				} else {
					return array(false, "Não foi possível atualizar, verifique os campos");
				}
			} else {
				return array(false, "Aluno passado não foi encontrado");
			}
		} else {
			$sqlcad = "INSERT INTO TALUNOS(NOMEALUNO, CPFALUNO, DATACADASTRO, EXALUNO, CURSO, TURMA, TELEFONE, CADASTROATIVO) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = $this->connection->prepare($sqlcad);
			$stmt->bind_param(
				"sssssssi",
				$prNomeAluno,
				$prCpfAluno,
				$dataAtual,
				$prExAluno,
				$prCurso,
				$prTurma,
				$prTelefone,
				$prCadastroAtivo
			);
			$retornoSql = $stmt->execute();
			if ($retornoSql) {
				return array(true, "Aluno criado com sucesso");
			} else {
				$err = $stmt->error;
				return array(false, "Não foi possível criar o aluno, erro: $err");
			}
		}
	}

	public function CountAlunos($campoEsp, $value)
	{
		if ((isset($campoEsp) || strlen($campoEsp > 0)) && isset($value)) {
			if ($campoEsp == "nome") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TALUNOS 
                           WHERE NOMEALUNO LIKE '%$value%'";
			} else if ($campoEsp == "cpf") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TALUNOS 
                           WHERE CPFALUNO = '$value'";
			} else if ($campoEsp == "curso") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TALUNOS 
                           WHERE CURSO LIKE '%$value%'";
			} else if ($campoEsp == "turma") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TALUNOS 
                           WHERE UPPER(TURMA) LIKE UPPER('%$value%')";
			} else if ($campoEsp == "all") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TALUNOS";
			} else {
				return 0;
			}

			$res = $this->connection->query($sqlConsAux);
			if ($res !== false && $res->num_rows > 0) {
				// Obtém o resultado da consulta
				$row = $res->fetch_assoc();
				$quantidade = $row['qtde'];
				return $quantidade;
			} else {
				return 0; // Caso não haja registros
			}
		} else {
			return 0;
		}
	}

	public function GetAlunosPage($limit, $offset)
	{
		$sql = "SELECT * FROM TALUNOS LIMIT $limit OFFSET $offset";

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idaluno"       => $row["IDALUNO"],
					"nomealuno"     => $row["NOMEALUNO"],
					"cpfaluno"      => $row["CPFALUNO"],
					"datacadastro"  => $row["DATACADASTRO"],
					"exaluno"       => $row["EXALUNO"],
					"curso"         => $row["CURSO"],
					"turma"         => $row["TURMA"],
					"telefone"      => $row["TELEFONE"],
					"cadastroativo" => $row["CADASTROATIVO"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function GetAlunosPageFilter($limit, $offset, $filter, $value = "")
	{

		if (!isset($filter) || strlen($filter) == 0) {
			$sql = "SELECT * FROM TALUNOS LIMIT $limit OFFSET $offset";
		} elseif ($filter == "nome") {
			$sql = "SELECT * FROM TALUNOS WHERE NOMEALUNO LIKE '%$value%' LIMIT $limit OFFSET $offset";
		} elseif ($filter == "cpf") {
			$sql = "SELECT * FROM TALUNOS WHERE CPFALUNO LIKE '%$value%' LIMIT $limit OFFSET $offset";
		} elseif ($filter == "curso") {
			$sql = "SELECT * FROM TALUNOS WHERE CURSO LIKE '%$value%' LIMIT $limit OFFSET $offset";
		} elseif ($filter == "turma") {
			$sql = "SELECT * FROM TALUNOS WHERE TURMA LIKE '%$value%' LIMIT $limit OFFSET $offset";
		}

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idaluno"       => $row["IDALUNO"],
					"nomealuno"     => $row["NOMEALUNO"],
					"cpfaluno"      => $row["CPFALUNO"],
					"datacadastro"  => $row["DATACADASTRO"],
					"exaluno"       => $row["EXALUNO"],
					"curso"         => $row["CURSO"],
					"turma"         => $row["TURMA"],
					"telefone"      => $row["TELEFONE"],
					"cadastroativo" => $row["CADASTROATIVO"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function DeleteAluno($id)
	{
		$sqlAux = "SELECT * FROM TALUNOS WHERE IDALUNO = $id";
		$resultadoSqlAux = $this->connection->query($sqlAux);

		if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
			$sql = "DELETE FROM TALUNOS WHERE IDALUNO = $id";
			$retornoSqlCad = $this->connection->query($sql);
			if ($retornoSqlCad) {
				$resp = array(true, "Registro deletado com sucesso!");
				return $resp;
			} else {
				$error = $this->connection->error;
				if (strpos($error, "FOREIGN KEY")){
					return array(false, "Não é possivel deletar esse aluno pois algum registro está relacionado a ele.");
				}
				$resp = array(false, "Não foi possível deletar. Erro: " . $error);
				return $resp;
			}
		} else {
			$resp = array(false, "Não foi encontrado o registro passado, verifique com o suporte.");
			return $resp;
		}
	}
}
