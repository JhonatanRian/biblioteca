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
		else if (($prTipoConsulta == 2) and ($ConsultaGeral == false)) {
			$filtro = " WHERE NIVELDEACESSO = '$prInfoConsulta'";
		}
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
	
	public function InsertEhUpdateOperadores($prIdOperador, $prNomeOperador, $prNivelDeAcesso) {
		if (!empty(trim($prIdOperador))) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
		
		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TBIBLIOTECA WHERE IDOPERADOR = $prIdOperador";
			$resultadoSqlAux = $this->connection->query($sqlAux);
            
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TBIBLIOTECA SET NOMEOPERADOR = '$prNomeOperador', NIVELDEACESSO = $prNivelDeAcesso WHERE IDOPERADOR = $prIdOperador";
				$retornoSqlCad = $this->connection->query($sqlCad);
				
				return "Registro atualizado com sucesso!";
			} else {
				return "Operador não encontrado para atualização!";
			}
				
		} else {
			$sqlcad = "INSERT INTO TBIBLIOTECA(NOMEOPERADOR, NIVELDEACESSO) VALUES ('$prNomeOperador', $prNivelDeAcesso)";
			$retornoSql = $this->connection->query($sqlcad);
			return "Registro inserido com sucesso!";
		}	
	}
}

?>