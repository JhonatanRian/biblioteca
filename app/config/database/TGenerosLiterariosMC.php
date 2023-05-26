<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	15/05/2023	Criado funções de manipulação da tabela TGENEROSLITERARIOS.	  
******************************************************************************************************************
*/
require_once 'ModuloConnection.php';

class Generos {
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

    public function GetInfoGeneros($prInfoConsulta, $prTipoConsulta) {        
		$retornoConsulta = array();
		$ConsultaGeral   = false;
		$filtro          = "";
		
		if (($prInfoConsulta == 0) and ($prTipoConsulta == 0)){
			$ConsultaGeral = true;
		}
		
		// Consulta por ID do GENERO
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDGENERO = $prInfoConsulta";
		}// Consulta por NOMEGENERO 
		else if (($prTipoConsulta == 1) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(NOMEGENERO), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}
		
		
		$sql = "SELECT * FROM TGENEROSLITERARIOS ".$filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){	
				$retornoConsulta[] = array(
					"idgenero"   => $row["IDGENERO"],
					"nomegenero" => $row["NOMEGENERO"]						
				);
			}
			return $retornoConsulta;
		}            
    }
	
	public function InsertEhUpdateGeneros($prIdGenero, $prNomeGenero) {
		if (!empty(trim($prIdGenero))) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
		
		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TGENEROSLITERARIOS WHERE IDGENERO = $prIdGenero";
			$resultadoSqlAux = $this->connection->query($sqlAux);
            
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TGENEROSLITERARIOS SET NOMEGENERO = '$prNomeGenero' WHERE IDGENERO = $prIdGenero";
				$retornoSqlCad = $this->connection->query($sqlCad);
				
				return "Registro atualizado com sucesso!";
			} else {
				return "Genero não encontrado para atualização!";
			}
				
		} else {
			if (trim($prNomeGenero) !== '') {
				$sqlcad = "INSERT INTO TGENEROSLITERARIOS(NOMEGENERO) VALUES ('$prNomeGenero')";
				$retornoSql = $this->connection->query($sqlcad);
				return "Registro inserido com sucesso!";
			}	
		}	
	}
}

?>