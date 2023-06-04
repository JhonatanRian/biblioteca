<?php
/*
**************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	16/05/2023	Criado funções de manipulação da tabela TEMPRESTIMOS_LIVROS.
000002          Nathan.Faria    26/05/2023  Removido filtro de consulta detalhada, criada consulta especifica para painel secretária.	  
000003          Nathan.Faria    29/05/2023  Feito ajuste de erro de execusão.
**************************************
*/

require_once 'ModuloConnection.php';

class Emprestimos
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

	public function GetInfoEmprestimos($prInfoConsulta, $prTipoConsulta)
	{
		$retornoConsulta = array();
		$filtro          = "";
		$ValorDeMultaConstante = 2;

		// Consulta por Ordem de Emprestimo
		if ($prTipoConsulta == 0) {
			$filtro = " WHERE ORDEMEMPRESTIMOS = $prInfoConsulta";
		} // Consulta por ID do Aluno 
		else if ($prTipoConsulta == 1) {
			$filtro = " WHERE IDALUNO = $prInfoConsulta";
		} // Consulta por ID do Livro 
		else if ($prTipoConsulta == 2) {
			$filtro = " WHERE IDLIVRO = $prInfoConsulta";
		} // Consulta por ID do Operador 
		else if ($prTipoConsulta == 3) {
			$filtro = " WHERE IDOPERADOR = $prInfoConsulta";
		} else if ($prTipoConsulta == 4) {
			$sqlConsAux = "SELECT EMP.IDALUNO, AL.NOMEALUNO, AL.TELEFONE, COUNT(EMP.IDALUNO) AS QTDE " .
				"FROM TEMPRESTIMOS_LIVROS EMP " .
				"LEFT OUTER JOIN TALUNOS AL ON (EMP.IDALUNO = AL.IDALUNO) " .
				"WHERE EMP.DATADADEVOLUCAO IS NULL " .
				"GROUP BY EMP.IDALUNO, AL.NOMEALUNO, AL.TELEFONE " .
				"ORDER BY QTDE DESC";
		} else if ($prTipoConsulta == 5) {
			$sqlConsAux = "SELECT EMP.*, AL.NOMEALUNO, LI.NOMELIVRO, DATEDIFF(NOW(), EMP.DATAPREVISTADEVOLUCAO) AS DIASATRASADO 
			              FROM TEMPRESTIMOS_LIVROS AS EMP 
			              LEFT OUTER JOIN TALUNOS AL ON (EMP.IDALUNO = AL.IDALUNO) 
						  LEFT OUTER JOIN TLIVROS LI ON (EMP.IDLIVRO = LI.IDLIVRO) 
						  WHERE AL.IDALUNO = $prInfoConsulta 
						  AND DATADADEVOLUCAO IS NULL ";
		} else {
			$sqlConsAux = "SELECT EMP.*, AL.NOMEALUNO, LI.NOMELIVRO, DATEDIFF(NOW(), EMP.DATAPREVISTADEVOLUCAO) AS DIASATRASADO
               FROM TEMPRESTIMOS_LIVROS EMP
               LEFT OUTER JOIN TALUNOS AL ON (EMP.IDALUNO = AL.IDALUNO)
               LEFT OUTER JOIN TLIVROS LI ON (EMP.IDLIVRO = LI.IDLIVRO)
               LEFT OUTER JOIN TBIBLIOTECA BL ON (EMP.IDOPERADOR = BL.IDOPERADOR)";
		}

		$sql = $sqlConsAux . $filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while ($row = $resultadoSqlCons->fetch_assoc()) {

				if ($prTipoConsulta == 4) {

					$retornoConsulta[] = array(
						"idaluno"               => $row["IDALUNO"],
						"nomealuno"             => $row["NOMEALUNO"],
						"telefone"              => $row["TELEFONE"],
						"qtde"                  => $row["QTDE"]
					);
				} else {
					$DiasAtrasado = $row["DIASATRASADO"];
					if ($DiasAtrasado < 0) {
						$DiasAtrasado = 0;
					}
					if ($row["DIASATRASADO"] < 0) {
						$ValorDaMulta = 0;
					} else {
						$ValorDaMulta = $row["DIASATRASADO"] * $ValorDeMultaConstante;
					}


					$retornoConsulta[] = array(
						"ordememprestimos"      => $row["ORDEMEMPRESTIMOS"],
						"idaluno"               => $row["IDALUNO"],
						"nomealuno"             => $row["NOMEALUNO"],
						"idlivro"               => $row["IDLIVRO"],
						"nomelivro"             => $row["NOMELIVRO"],
						"idoperador"            => $row["IDOPERADOR"],
						"dataemprestimo"        => $row["DATAEMPRESTIMO"],
						"dataprevistadevolucao" => $row["DATAPREVISTADEVOLUCAO"],
						"datadadevolucao"       => $row["DATADADEVOLUCAO"],
						"diasatrasado"          => $DiasAtrasado,
						"valordamulta"          => $ValorDaMulta
					);
				}
			}
			return $retornoConsulta;
		}
	}

	public function CountEmpAluno($id)
	{
		$sqlConsAux = "SELECT COUNT(*) AS qtde " .
			"FROM TEMPRESTIMOS_LIVROS " .
			"WHERE IDALUNO = $id " .
			"AND DATADADEVOLUCAO IS NULL ";
		$res = $this->connection->query($sqlConsAux);
		if ($res !== false && $res->num_rows > 0) {
			// Obtém o resultado da consulta
			$row = $res->fetch_assoc();
			$quantidade = $row['qtde'];
			return $quantidade;
		} else {
			return 0; // Caso não haja empréstimos
		}
	}

	public function InsertEmprestimos(
		$prIdAluno,
		$prIdLivro,
		$prIdOperador,
		$prDataEmprestimos,
		$prDataPrevistaDevolucao,
		$prDataDaDevolucao
	) {

		$sqlcad = "INSERT INTO TEMPRESTIMOS_LIVROS(IDALUNO, IDLIVRO, IDOPERADOR, DATAEMPRESTIMO, DATAPREVISTADEVOLUCAO) VALUES " .
			"($prIdAluno, $prIdLivro, $prIdOperador, '$prDataEmprestimos', '$prDataPrevistaDevolucao')";
		$retornoSql = $this->connection->query($sqlcad);
		if ($retornoSql) {
			$resp = array(true, "Registro inserido com sucesso!");
			return $resp;
		} else {
			$resp = array(false, "Não foi possivel fazer o cadastro, verifique com o suporte.");
			return $resp;
		}
	}
	public function UpdateEmprestimo($prOrdemEmprestimos, $prDataPrevistaDevolucao, $prDataDaDevolucao)
	{
		$sqlAux = "SELECT * FROM TEMPRESTIMOS_LIVROS WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
		$resultadoSqlAux = $this->connection->query($sqlAux);

		if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
			if (strlen($prDataPrevistaDevolucao) > 0 and strlen($prDataDaDevolucao) > 0) {
				$sqlCad = "UPDATE TEMPRESTIMOS_LIVROS SET DATAPREVISTADEVOLUCAO = '$prDataPrevistaDevolucao' 
				           DATADADEVOLUCAO = '$prDataDaDevolucao' WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
			} else if (strlen($prDataPrevistaDevolucao) > 0 and !(strlen($prDataDaDevolucao) > 0)) {
				$sqlCad = "UPDATE TEMPRESTIMOS_LIVROS SET DATAPREVISTADEVOLUCAO = '$prDataPrevistaDevolucao' 
						   WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
			} else if (!(strlen($prDataPrevistaDevolucao) > 0) and strlen($prDataDaDevolucao) > 0) {
				$sqlCad = "UPDATE TEMPRESTIMOS_LIVROS SET DATADADEVOLUCAO = '$prDataDaDevolucao'
						   WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
			}

			$retornoSqlCad = $this->connection->query($sqlCad);
			if ($retornoSqlCad) {
				$resp = array(true, "Registro atualizado com sucesso!");
				return $resp;
			} else {
				$resp = array(false, "Não foi possivel fazer o cadastro, verifique com o suporte.");
				return $resp;
			}
		} else {
			$resp = array(false, "Informaçãos do emprestimo de livro não encontrado para atualização!");
			return $resp;
		}
	}

	public function DeleteEmprestimo($prOrdemEmprestimos)
	{

		$sqlAux = "SELECT * FROM TEMPRESTIMOS_LIVROS WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
		$resultadoSqlAux = $this->connection->query($sqlAux);

		if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
			$sql = "DELETE FROM TEMPRESTIMOS_LIVROS WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
			$retornoSqlCad = $this->connection->query($sql);
			if ($retornoSqlCad) {
				$resp = array(true, "Registro deletado com sucesso!");
				return $resp;
			} else {
				$error = $this->connection->error;
				$resp = array(false, "Não foi possível deletar. Erro: " . $error);
				return $resp;
			}
		} else {
			$resp = array(false, "Não foi encontrado o aluguel passado, verifique com o suporte.");
			return $resp;
		}
	}
}
