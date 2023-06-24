<?php
/*
******************************************************************************************************************
Solicitação		Programador   	Data        Alteração
000001			Nathan.Faria	16/05/2023	Criado funções de manipulação da tabela TLIVROS.	  
******************************************************************************************************************
*/

require_once 'ModuloConnection.php';

class Livros {
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

    public function GetInfoLivros($prInfoConsulta, $prTipoConsulta) {        
		$retornoConsulta = array();
		$filtro          = "";
		$ConsultaGeral   = false;
		
		if (($prInfoConsulta == 0) and ($prTipoConsulta == 0)){
			$ConsultaGeral = true;
		}else{
			$prInfoConsulta = $this->connection->real_escape_string($prInfoConsulta);
		}

		// Consulta por ID do LIVRO
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$sql2 = "SELECT TL.*, TG.NOMEGENERO AS NOMEGENERO
        			FROM TLIVROS TL
        			INNER JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO
        			WHERE TL.IDLIVRO LIKE '%$prInfoConsulta%'";
		}// Consulta por NOMELIVRO 
		else if (($prTipoConsulta == 1) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(NOMELIVRO), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')";
		}// Consulta por NOMEAUTOR 
		else if (($prTipoConsulta == 2) and ($ConsultaGeral == false)) {
			$filtro = " WHERE REPLACE(UPPER(NOMEAUTOR), '.', '') LIKE REPLACE(UPPER('%$prInfoConsulta%'), '.', '')"; 
		}// Consulta por GENERO 
		else if (($prTipoConsulta == 3) and ($ConsultaGeral == false)) {
			$filtro = " WHERE GENERO = $prInfoConsulta";
		}
		
		if ($prTipoConsulta == 0){
			$sql = $sql2;
			$resultadoSqlCons = $this->connection->query($sql);
			if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
				while($row = $resultadoSqlCons->fetch_assoc()){	
					$retornoConsulta[] = array(
						"idlivro"       => $row["IDLIVRO"],
						"nomelivro"     => $row["NOMELIVRO"],
						"nomeautor"     => $row["NOMEAUTOR"],
						"corcapa"     => $row["CORCAPA"],
						"fonte"     => $row["FONTE"],
						"qtde"          => $row["QTDE"],
						"genero"        => $row["GENERO"],
						"nomegenero"        => $row["NOMEGENERO"],
						"sinopse"       => $row["SINOPSE"],
						"cadastroativo" => $row["CADASTROATIVO"]
						
					);
				}
				return $retornoConsulta;
			}
		} else {
			$sql = "SELECT * FROM TLIVROS ".$filtro;
		}
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){	
				$retornoConsulta[] = array(
					"idlivro"       => $row["IDLIVRO"],
					"nomelivro"     => $row["NOMELIVRO"],
					"nomeautor"     => $row["NOMEAUTOR"],
					"corcapa"     => $row["CORCAPA"],
					"fonte"     => $row["FONTE"],
					"qtde"          => $row["QTDE"],
					"genero"        => $row["GENERO"],
					"sinopse"       => $row["SINOPSE"],
					"cadastroativo" => $row["CADASTROATIVO"]
					
				);
			}
			return $retornoConsulta;
		}
    }
	
	function GetLivrosNovos() {
		$sql = "SELECT * FROM TLIVROS ORDER BY IDLIVRO DESC LIMIT 30;";
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){	
				$retornoConsulta[] = array(
					"idlivro"       => $row["IDLIVRO"],
					"nomelivro"     => $row["NOMELIVRO"],
					"nomeautor"     => $row["NOMEAUTOR"],
					"corcapa"     => $row["CORCAPA"],
					"fonte"     => $row["FONTE"],
					"qtde"          => $row["QTDE"],
					"genero"        => $row["GENERO"],
					"sinopse"       => $row["SINOPSE"],
					"cadastroativo" => $row["CADASTROATIVO"]
					
				);
			}
			return $retornoConsulta;
		} else {
			return array();
		}
	}

	public function InsertEhUpdateLivros($prIdLivro, $prNomeLivro, $prNomeAutor, $prGenero, $prQtde, $prSinopse, $prCadastroAtivo, $corcapa = "book-brown", $fonte = "book-text-rajd") {

		if (isInteger($prIdLivro)) {
			$sqlAux = "SELECT * FROM TLIVROS WHERE IDLIVRO = $prIdLivro";
			$resultadoSqlAux = $this->connection->query($sqlAux);
			if ($resultadoSqlAux){
				$sqlCad = "UPDATE TLIVROS SET NOMELIVRO = '$prNomeLivro', NOMEAUTOR = '$prNomeAutor', GENERO = $prGenero, ".
				"QTDE = $prQtde, SINOPSE = '$prSinopse', CADASTROATIVO = $prCadastroAtivo, CORCAPA = '$corcapa', FONTE = '$fonte' WHERE IDLIVRO = $prIdLivro";
				$retornoSqlCad = $this->connection->query($sqlCad);
				if ($retornoSqlCad) {
					return array(true, "Registro atualizado com sucesso");
				} else {
					$err = $this->connection->error;
					return array(false, "Não foi possivel atualizar o registro, erro: $err");
				}
			} else {
				return array(false, "Registro não foi encontrado");
			}	
		} else {
			if (trim($prNomeLivro) !== '' and trim($prNomeAutor) !== '' and trim($prGenero) !== '' and trim($prQtde) !== '' and trim($prSinopse) !== '') {
				$sqlcad = "INSERT INTO TLIVROS(NOMELIVRO, NOMEAUTOR, GENERO, QTDE, SINOPSE, CADASTROATIVO, CORCAPA, FONTE) VALUES ('$prNomeLivro', '$prNomeAutor', '$prGenero', '$prQtde', '$prSinopse', $prCadastroAtivo, '$corcapa', '$fonte')";
				$retornoSql = $this->connection->query($sqlcad);
				if ($retornoSql) {
					return array(true, "Registro inserido com sucesso!");
				} else {
					$err = $this->connection->error;
					return array(false, "Não foi possivel salvar o registro: $err");
				}
				return ;
			} else {
				return array(false, "Não foi possivel salvar os dados passados.");
			}
		}	
	}

	public function CountLivros($campoEsp, $value)
	{
		if ((isset($campoEsp) || strlen($campoEsp > 0)) && isset($value)) {
			if ($campoEsp == "nome") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TLIVROS 
                           WHERE NOMELIVRO LIKE '%$value%'";
			} else if ($campoEsp == "autor") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TLIVROS 
                           WHERE NOMEAUTOR = '$value'";
			} else if ($campoEsp == "genero") {
				$sqlConsAux = "SELECT COUNT(TL.IDLIVRO) AS qtde 
				FROM TLIVROS TL 
				JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO 
				WHERE TG.NOMEGENERO LIKE '%$value%';";
			} else if ($campoEsp == "all") {
				$sqlConsAux = "SELECT COUNT(*) AS qtde 
                           FROM TLIVROS";
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

	public function GetLivrosPage($limit, $offset)
	{
		$sql = "SELECT TL.*, TG.NOMEGENERO AS NOMEGENERO
        			FROM TLIVROS TL
        			INNER JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO
        			LIMIT $limit OFFSET $offset";

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idlivro"       => $row["IDLIVRO"],
					"nomelivro"     => $row["NOMELIVRO"],
					"nomeautor"     => $row["NOMEAUTOR"],
					"corcapa"     => $row["CORCAPA"],
					"fonte"     => $row["FONTE"],
					"qtde"          => $row["QTDE"],
					"genero"        => $row["GENERO"],
					"nomegenero"        => $row["NOMEGENERO"],
					"sinopse"       => $row["SINOPSE"],
					"cadastroativo" => $row["CADASTROATIVO"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function GetLivrosPageFilter($limit, $offset, $filter, $value = "")
	{

		if (!isset($filter) || strlen($filter) == 0) {
			$sql = "SELECT TL.*, TG.NOMEGENERO AS NOMEGENERO
        			FROM TLIVROS TL
        			INNER JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO
        			LIMIT $limit OFFSET $offset";
		} elseif ($filter == "nome") {
			$sql = $sql = "SELECT TL.*, TG.NOMEGENERO AS NOMEGENERO
							FROM TLIVROS TL
							INNER JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO
							WHERE TL.NOMELIVRO LIKE '%$value%'
							LIMIT $limit OFFSET $offset";
		} elseif ($filter == "autor") {
			$sql = "SELECT TL.*, TG.NOMEGENERO AS NOMEGENERO
					FROM TLIVROS TL
					INNER JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO
					WHERE TL.NOMEAUTOR LIKE '%$value%'
					LIMIT $limit OFFSET $offset";
		} elseif ($filter == "genero") {
			$sql = "SELECT TL.*, TG.NOMEGENERO AS NOMEGENERO
        			FROM TLIVROS TL
        			INNER JOIN TGENEROSLITERARIOS TG ON TL.GENERO = TG.IDGENERO
        			WHERE TG.NOMEGENERO LIKE '%$value%'
        			LIMIT $limit OFFSET $offset";
		} 

		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			$retornoConsulta = array(); // Inicializar a variável como um array vazio

			while ($row = $resultadoSqlCons->fetch_assoc()) {
				$retornoConsulta[] = array(
					"idlivro"       => $row["IDLIVRO"],
					"nomelivro"     => $row["NOMELIVRO"],
					"nomeautor"     => $row["NOMEAUTOR"],
					"corcapa"     => $row["CORCAPA"],
					"fonte"     => $row["FONTE"],
					"qtde"          => $row["QTDE"],
					"genero"        => $row["GENERO"],
					"nomegenero"        => $row["NOMEGENERO"],
					"sinopse"       => $row["SINOPSE"],
					"cadastroativo" => $row["CADASTROATIVO"]
				);
			}
			return $retornoConsulta;
		} else {
			return false;
		}
	}

	public function DeleteLivro($id)
	{
		$sqlAux = "SELECT * FROM TLIVROS WHERE IDLIVRO = $id";
		$resultadoSqlAux = $this->connection->query($sqlAux);

		if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
			$sql = "DELETE FROM TLIVROS WHERE IDLIVRO = $id";
			$retornoSqlCad = $this->connection->query($sql);
			if ($retornoSqlCad) {
				$resp = array(true, "Registro deletado com sucesso!");
				return $resp;
			} else {
				$error = $this->connection->error;
				if (strpos($error, "FOREIGN KEY")){
					return array(false, "Não é possivel deletar esse livro pois algum registro está relacionado a ele.");
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
function isInteger($str) {
    // Remove espaços em branco do início e fim da string
    $str = trim($str);

    // Verifica se a string é numérica e se o valor convertido para inteiro é igual ao valor original
    return is_numeric($str) && intval($str) == $str;
}
?>