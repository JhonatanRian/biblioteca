<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	16/05/2023	Criado funções de manipulação da tabela TEMPRESTIMOS_LIVROS.	  
******************************************************************************************************************
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

    public function GetInfoEmprestimos($prInfoConsulta, $prTipoConsulta, $prConsultaDetalhada) {        
		$retornoConsulta = array();
		$filtro          = "";
		$ConsultaGeral   = false;
		$ValorDeMultaConstante = 2;
		
		if (($prInfoConsulta == 0) and ($prTipoConsulta == 0) and ($prConsultaDetalhada == 0)){
			$ConsultaGeral   = true;
		}
		
		// Consulta por Ordem de Emprestimo
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$filtro = " WHERE ORDEMEMPRESTIMOS = $prInfoConsulta";
		}// Consulta por ID do Aluno 
		else if (($prTipoConsulta == 1) and ($ConsultaGeral == false)){
			$filtro = " WHERE IDALUNO = $prInfoConsulta";
		}// Consulta por ID do Livro 
		else if (($prTipoConsulta == 2) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDLIVRO = $prInfoConsulta";
		}// Consulta por ID do Operador 
		else if (($prTipoConsulta == 3) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDOPERADOR = $prInfoConsulta";
		}
		
		if (($prConsultaDetalhada == 0) and ($ConsultaGeral == false)) {
			$sqlConsAux = "SELECT * FROM TEMPRESTIMOS_LIVROS";
		} else {
			$sqlConsAux = " SELECT EMP.*, CASE WHEN ((EMP.DATADADEVOLUCAO IS NULL) OR (EMP.DATAPREVISTADEVOLUCAO < EMP.DATADADEVOLUCAO)) THEN DATEDIFF(NOW(), DATAPREVISTADEVOLUCAO) ELSE 0 END AS DIASATRASADO ".
			              " FROM temprestimos_livros EMP LEFT OUTER JOIN talunos AL ON (EMP.IDALUNO = AL.IDALUNO) ". 
						  " LEFT OUTER JOIN tlivros LI ON (EMP.IDLIVRO = LI.IDLIVRO) ".
		                  " LEFT OUTER JOIN tbiblioteca BL ON (EMP.IDOPERADOR = BL.IDOPERADOR)";
		}
		
		if ($prTipoConsulta == 0) {
            $sql = $sqlConsAux.$filtro;
            $resultadoSqlCons = $this->connection->query($sql);
            if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
                while($row = $resultadoSqlCons->fetch_assoc()){
					if (($prConsultaDetalhada == 1) or ($ConsultaGeral == true)) {
							$DiasAtrasado = $row["DIASATRASADO"];							
							$ValorDaMulta = 0;
							$ValorDaMulta = $row["DIASATRASADO"] * $ValorDeMultaConstante;
						}
						
					$retornoConsulta[] = array( 
						"ordememprestimos"      => $row["ORDEMEMPRESTIMOS"],
						"idaluno"               => $row["IDALUNO"],
						"idlivro"               => $row["IDLIVRO"],
						"idoperador"            => $row["IDOPERADOR"],
						"dataemprestimo"        => $row["DATAEMPRESTIMO"],
						"dataprevistadevolucao" => $row["DATAPREVISTADEVOLUCAO"],
						"datadadevolucao"       => $row["DATADADEVOLUCAO"],
						"diasatrasado"          => $DiasAtrasado,
						"valordamulta"          => $ValorDaMulta						
					);
                }
				return $retornoConsulta;
            }            
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
				return "Livro não encontrado para atualização!";
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