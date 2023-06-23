<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	15/05/2023	Criado funções de manipulação da tabela TBIBLIOTECA.	  
******************************************************************************************************************
*/

require_once 'ModuloConnection.php';

class Biblioteca {
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

    public function GetInfoOperadores($prInfoConsulta, $prTipoConsulta) {        
		$retornoConsulta = array();
		$ConsultaGeral   = false;
		$filtro          = "";
		if (($prInfoConsulta == 0) and ($prTipoConsulta == 0)){
			$ConsultaGeral = true;
		}
		
		// Consulta por ID do OPERADOR
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDOPERADOR = $prInfoConsulta";
		}// Consulta por NOMEOPERADOR
		else if (($prTipoConsulta == 1) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(NOMEOPERADOR), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}// Consulta por NIVELDEACESSO
		else if (($prTipoConsulta == 3) and ($ConsultaGeral == false)) {
			$prInfoConsulta = $this->connection->real_escape_string($prInfoConsulta);
			$filtro = " WHERE CPF = '$prInfoConsulta'";
		}
		
		$sql = "SELECT * FROM TBIBLIOTECA ".$filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){
				$retornoConsulta[] = array(
					"idoperador"       => $row["IDOPERADOR"],
					"nomeoperador"     => $row["NOMEOPERADOR"],						
					"cpf"     => $row["CPF"],						
					"is_staff"    => $row["IS_STAFF"],
					"is_superuser" => $row["IS_SUPERUSER"]						
				);
			}
			return $retornoConsulta;
		}            
               
        
    }
	
	public function VerificarLogin($cpf, $senha) {
		$cpf = $this->connection->real_escape_string($cpf);
		$senha = $this->connection->real_escape_string($senha);

		$sql = "SELECT * FROM `TBIBLIOTECA` WHERE CPF = '$cpf' AND SENHA = '$senha'";

		$results = $this->connection->query(($sql));
		$numRows = $results->num_rows;
		if ($numRows == 1){
			$user = $results->fetch_assoc();
			return $user;
		}else {
			return false;
		}

	}
	
	public function InsertEhUpdateOperadores($prIdOperador, $prNomeOperador, $cpf, $senha, $is_staff, $is_superuser) {
		if (isset($prIdOperador) and $prIdOperador >= 1) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
		
		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TBIBLIOTECA WHERE IDOPERADOR = $prIdOperador";
			$resultadoSqlAux = $this->connection->query($sqlAux);
            
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				if (isset($senha) and strlen(trim($senha)) > 8) {
					$sqlCad = "UPDATE TBIBLIOTECA SET NOMEOPERADOR = '$prNomeOperador', CPF = '$cpf', SENHA = '$senha', IS_STAFF = '$is_staff', IS_SUPERUSER = '$is_superuser' WHERE IDOPERADOR = $prIdOperador";
				} else if (strlen($senha) > 0 and strlen($senha) < 8){
					return array(false, "A senha de deve ter pelo menos 8 caracter");
				} else {
					$sqlCad = "UPDATE TBIBLIOTECA SET NOMEOPERADOR = '$prNomeOperador', CPF = '$cpf', IS_STAFF = '$is_staff', IS_SUPERUSER = '$is_superuser' WHERE IDOPERADOR = $prIdOperador";
				}
				$retornoSqlCad = $this->connection->query($sqlCad);
				
				if ($retornoSqlCad) {
					return array(true, "Dados atualizados com sucesso");
				} else {
					return array(false, "Não foi possível atualizar, verifique os campos");
				}
			} else {
				return "Operador não encontrado para atualização!";
			}
				
		} else {
			$sqlcad = "INSERT INTO TBIBLIOTECA(NOMEOPERADOR, CPF, SENHA, IS_STAFF, IS_SUPERUSER) VALUES (?, ?, ?, ?, ?)";
			$stmt = $this->connection->prepare($sqlcad);
			$stmt->bind_param(
				"sssii",
				$prNomeOperador,
				$cpf,
				$senha,
				$is_staff,
				$is_superuser);
			$retornoSql = $stmt->execute();

			if ($retornoSql) {
				return array(true, "Operario criado com sucesso");
			} else {
				$err = $stmt->error;
				return array(false, "Não foi possível criar o operario, erro: $err");
			}
		}	
	}

	public function CountOp($campoEsp, $value)
	{
		if ((isset($campoEsp) || strlen($campoEsp > 0)) && isset($value)) {
			if ($campoEsp == "nome") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TBLIBIOTECA 
                           WHERE NOMEOPERADOR LIKE '%$value%'";
			} else if ($campoEsp == "cpf") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TBIBLIOTECA 
                           WHERE CPF = '$value'";
			} else if ($campoEsp == "all") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TBIBLIOTECA";
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

	public function GetOpPage($limit, $offset)
	{
		$sql = "SELECT * FROM TBIBLIOTECA LIMIT $limit OFFSET $offset";

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idoperador"       => $row["IDOPERADOR"],
					"nomeoperador"     => $row["NOMEOPERADOR"],
					"cpf"      => $row["CPF"],
					"is_staff" => $row["IS_STAFF"],
					"is_superuser" => $row["IS_SUPERUSER"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function GetOpPageFilter($limit, $offset, $filter, $value = "")
	{

		if (!isset($filter) || strlen($filter) == 0) {
			$sql = "SELECT *
        			FROM TBIBLIOTECA
        			LIMIT $limit OFFSET $offset";
		} elseif ($filter == "nome") {
			$sql = "SELECT *
        			FROM TBIBLIOTECA
					WHERE NOMEOPERADOR LIKE '%$value%' 
        			LIMIT $limit OFFSET $offset";
		} elseif ($filter == "cpf") {
			$sql = "SELECT *
        			FROM TBIBLIOTECA
					WHERE CPF LIKE '%$value%' 
        			LIMIT $limit OFFSET $offset";
		} 

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idoperador"       => $row["IDOPERADOR"],
					"nomeoperador"     => $row["NOMEOPERADOR"],
					"cpf"      => $row["CPF"],
					"is_staff" => $row["IS_STAFF"],
					"is_superuser" => $row["IS_SUPERUSER"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function DeleteOp($id)
	{
		$sqlAux = "SELECT * FROM TBIBLIOTECA WHERE IDOPERADOR = $id";
		$resultadoSqlAux = $this->connection->query($sqlAux);

		if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
			$sql = "DELETE FROM TBIBLIOTECA WHERE IDOPERADOR = $id";
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

?>