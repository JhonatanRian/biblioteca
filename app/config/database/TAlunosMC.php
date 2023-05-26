<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	15/05/2023	Criado funções de manipulação da tabela TALUNOS.	  
******************************************************************************************************************
*/

require_once 'ModuloConnection.php';

class Alunos {
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

    public function GetInfoAlunos($prInfoConsulta, $prTipoConsulta) {        
		$retornoConsulta = array();
		$ConsultaGeral   = false;
		$filtro          = "";
		
		if (($prInfoConsulta == 0) and ($prTipoConsulta == 0)){
			$ConsultaGeral = true;
		}
		
		// Consulta por ID do ALUNO
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDALUNO = $prInfoConsulta";
		}// Consulta por NOMEALUNO 
		else if (($prTipoConsulta == 1) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(NOMEALUNO), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}// Consulta por CPFALUNO 
		else if (($prTipoConsulta == 2) and ($ConsultaGeral == false)) {
			$filtro = " WHERE CPFALUNO = '$prInfoConsulta'";
		}// Consulta por CURSO 
		else if (($prTipoConsulta == 3) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(CURSO), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}// Consulta por TURMA
		else if (($prTipoConsulta == 4) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(TURMA), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}
		
		$sql = "SELECT * FROM TALUNOS ".$filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){	
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
		}            
                
        
    }
	
	
	public function InsertEhUpdateAlunos($prIdAluno, $prNomeAluno, $prCpfAluno, $prDataCadastro, $prExAluno, $prCurso, $prTurma, $prTelefone, $prCadastroAtivo) {
		if (!empty(trim($prIdAluno))) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
		
		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TALUNOS WHERE IDALUNO = $prIdAluno";
			$resultadoSqlAux = $this->connection->query($sqlAux);
            
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TALUNOS SET NOMEALUNO = '$prNomeAluno', CPFALUNO = '$prCpfAluno', DATACADASTRO = '$prDataCadastro',".
				" EXALUNO = $prExAluno, CURSO = '$prCurso', TURMA = '$prTurma', TELEFONE = '$prTelefone',".
                " CADASTROATIVO = $prCadastroAtivo  WHERE IDALUNO = $prIdAluno";
				$retornoSqlCad = $this->connection->query($sqlCad);
				
				return "Registro atualizado com sucesso!";
			} else {
				return "Aluno não encontrado para atualização!";
			}
				
		} else {
			$sqlcad = "INSERT INTO TALUNOS(NOMEALUNO, CPFALUNO, DATACADASTRO, EXALUNO, CURSO, TURMA, TELEFONE, CADASTROATIVO) VALUES ('$prNomeAluno', '$prCpfAluno', '$prDataCadastro', $prExAluno, '$prCurso', '$prTurma', '$prTelefone', $prCadastroAtivo)";
			$retornoSql = $this->connection->query($sqlcad);
			return "Registro inserido com sucesso!";
		}	
	}
}

?>