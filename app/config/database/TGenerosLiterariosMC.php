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

    public function GetInfoGeneros($prInfoConsulta, $prTipoConsulta) 
	{        
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
	
	public function InsertEhUpdateGeneros($prIdGenero, $prNomeGenero) 
	{
		$prIdGenero = trim($prIdGenero);
		$prNomeGenero = trim($prNomeGenero);
	
		if (!empty($prIdGenero)) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
	
		if ($AtualizaRegistro) {
			$sqlAux = "SELECT * FROM TGENEROSLITERARIOS WHERE IDGENERO = $prIdGenero";
			$resultadoSqlAux = $this->connection->query($sqlAux);
	
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TGENEROSLITERARIOS SET NOMEGENERO = '$prNomeGenero' WHERE IDGENERO = $prIdGenero";
				$retornoSqlCad = $this->connection->query($sqlCad);
				if ($retornoSqlCad) {
					return array(true, "Registro atualizado com sucesso!");
				} else {
					return array(false, "Não foi possível atualizar o registro.");
				}
			} else {
				return array(false, "Gênero não encontrado para atualização!");
			}
		} else {
			if (!empty($prNomeGenero)) {
				$sqlcad = "INSERT INTO TGENEROSLITERARIOS(NOMEGENERO) VALUES ('$prNomeGenero')";
				$retornoSql = $this->connection->query($sqlcad);
				if ($retornoSql) {
					return array(true, "Registro inserido com sucesso!");
				} else {
					return array(false, "Não foi possível inserir os dados.");
				}
			}
		}
	
		return array(false, "Parâmetros inválidos.");
	}

	public function CountGeneros($value)
	{
		if (isset($value) || strlen($value) > 0) {
			$sqlConsAux = "SELECT COUNT(*) AS qtde 
						FROM TGENEROSLITERARIOS 
						WHERE NOMEGENERO LIKE '%$value%'";
		} else {
			$sqlConsAux = "SELECT COUNT(*) AS qtde 
						FROM TGENEROSLITERARIOS";
		} 

		$res = $this->connection->query($sqlConsAux);
		if ($res !== false && $res->num_rows > 0) {
			$row = $res->fetch_assoc();
			$quantidade = $row['qtde'];
			return $quantidade;
		} else {
			return 0;
		}
	}

	public function GetGenerosPage($limit, $offset) 
	{
		$sql = "SELECT * FROM TGENEROSLITERARIOS LIMIT $limit OFFSET $offset";

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idgenero"       => $row["IDGENERO"],
					"nomegenero"     => $row["NOMEGENERO"],
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function GetGenerosPageFilter($limit, $offset, $value = "")
	{
		if (!isset($value) || strlen($value) == 0) {
			$sql = "SELECT * FROM TGENEROSLITERARIOS LIMIT $limit OFFSET $offset";
		} else {
			$sql = "SELECT * FROM TGENEROSLITERARIOS WHERE NOMEGENERO LIKE '%$value%' LIMIT $limit OFFSET $offset";
		}

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idgenero"       => $row["IDGENERO"],
					"nomegenero"     => $row["NOMEGENERO"],
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function DeleteGenero($id)
	{
		$sqlAux = "SELECT * FROM TGENEROSLITERARIOS WHERE IDGENERO = $id";
		$resultadoSqlAux = $this->connection->query($sqlAux);

		if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
			$sql = "DELETE FROM TGENEROSLITERARIOS WHERE IDGENERO = $id";
			$retornoSqlCad = $this->connection->query($sql);
			if ($retornoSqlCad) {
				$resp = array(true, "Registro deletado com sucesso!");
				return $resp;
			} else {
				$error = $this->connection->error;
				if (strpos($error, "FOREIGN KEY")){
					return array(false, "Não é possivel deletar esse genero pois algum registro está relacionado a ele.");
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
?>