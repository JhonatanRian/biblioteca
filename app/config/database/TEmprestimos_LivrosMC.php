<?php
/*
**************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	16/05/2023	Criado funções de manipulação da tabela TEMPRESTIMOS_LIVROS.
000002          Nathan.Faria    26/05/2023  Removido filtro de consulta detalhada, criada consulta especifica para painel secretária.	  
**************************************
*/

require_once 'ModuloConnection.php';

class Emprestimos {
	private $connection;
	
    public function __construct() {
        global $servername, $username, $password, $basename;
        $this->connection = new mysqli($servername, $username, $password, $basename);
        if ($this->connection->connect_error) {
            die("Erro de conexão com o banco: " . $this->connection->connect_error);
        }
		//else {
		//	echo "Conexão estabelecida com exito!";	
		//}
    }

    public function GetInfoEmprestimos($prInfoConsulta, $prTipoConsulta) {        
		$retornoConsulta = array();
		$filtro          = "";
		$ValorDeMultaConstante = 2;
		
		// Consulta por Ordem de Emprestimo
		if ($prTipoConsulta == 0) {
			$filtro = " WHERE ORDEMEMPRESTIMOS = $prInfoConsulta";
		}// Consulta por ID do Aluno 
		else if ($prTipoConsulta == 1){
			$filtro = " WHERE IDALUNO = $prInfoConsulta";
		}// Consulta por ID do Livro 
		else if ($prTipoConsulta == 2) {
			$filtro = " WHERE IDLIVRO = $prInfoConsulta";
		}// Consulta por ID do Operador 
		else if ($prTipoConsulta == 3) {
			$filtro = " WHERE IDOPERADOR = $prInfoConsulta";
		}

		if ($prTipoConsulta == 4) {
			$sqlConsAux = " SELECT EMP.IDALUNO, AL.NOMEALUNO, AL.TELEFONE, COUNT(EMP.IDALUNO) AS QTDE ".
						  " FROM TEMPRESTIMOS_LIVROS EMP ".
						  " LEFT OUTER JOIN TALUNOS AL ON (EMP.IDALUNO = AL.IDALUNO) ".
						  " GROUP BY EMP.IDALUNO, AL.NOMEALUNO, AL.TELEFONE ".
						  " ORDER BY QTDE DESC ";

		} else {
			$sqlConsAux = " SELECT EMP.*, AL.NOMEALUNO, LI.NOMELIVRO, CASE WHEN ((EMP.DATADADEVOLUCAO IS NULL) OR (EMP.DATAPREVISTADEVOLUCAO < EMP.DATADADEVOLUCAO)) THEN DATEDIFF(NOW(), DATAPREVISTADEVOLUCAO) ELSE 0 END AS DIASATRASADO ".
						  " FROM temprestimos_livros EMP ".
						  " LEFT OUTER JOIN talunos AL ON (EMP.IDALUNO = AL.IDALUNO) ". 
						  " LEFT OUTER JOIN tlivros LI ON (EMP.IDLIVRO = LI.IDLIVRO) ".
						  " LEFT OUTER JOIN tbiblioteca BL ON (EMP.IDOPERADOR = BL.IDOPERADOR)";
		}
	
		$sql = $sqlConsAux.$filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){
				$DiasAtrasado = $row["DIASATRASADO"];							
				$ValorDaMulta = 0;
				$ValorDaMulta = $row["DIASATRASADO"] * $ValorDeMultaConstante;
				
				if ($prTipoConsulta == 4) {
					$retornoConsulta[] = array( 
					"ordememprestimos"      => $row["ORDEMEMPRESTIMOS"],
					"idaluno"               => $row["IDALUNO"],
					"nomealuno"             => $row["NOMEALUNO"],					
					"telefone"              => $row["TELEFONE"],
					"qtde"                  => $row["QTDE"]
					);
				}
				else {
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
	
	public function InsertEhUpdateEmprestimos($prOrdemEmprestimos, $prIdAluno, $prIdLivro, $prIdOperador, 
	$prDataEmprestimos, $prDataPrevistaDevolucao, $prDataDaDevolucao) {
		if (!empty(trim($prOrdemEmprestimos))) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
		
		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TEMPRESTIMOS_LIVROS WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
			$resultadoSqlAux = $this->connection->query($sqlAux);
            
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TEMPRESTIMOS_LIVROS SET IDALUNO = $prIdAluno, IDLIVRO = $prIdLivro, IDOPERADOR = $prIdOperador,".
				"DATAEMPRESTIMO = '$prDataEmprestimos', DATAPREVISTADEVOLUCAO = '$prDataPrevistaDevolucao', DATADADEVOLUCAO = '$prDataDaDevolucao' WHERE ORDEMEMPRESTIMOS = $prOrdemEmprestimos";
				$retornoSqlCad = $this->connection->query($sqlCad);
				
				return "Registro atualizado com sucesso!";
			} else {
				return "Informçãos do emprestimo de livro não encontrado para atualização!";
			}
				
		} else {
			$sqlcad = "INSERT INTO TEMPRESTIMOS_LIVROS(IDALUNO, IDLIVRO, IDOPERADOR, DATAEMPRESTIMO, DATAPREVISTADEVOLUCAO, DATADADEVOLUCAO) VALUES ".
			"($prIdAluno, $prIdLivro, $prIdOperador, '$prDataEmprestimos', '$prDataPrevistaDevolucao', '$prDataDaDevolucao')";
			$retornoSql = $this->connection->query($sqlcad);
			return "Registro inserido com sucesso!";
					
		}	
	}
}

?>