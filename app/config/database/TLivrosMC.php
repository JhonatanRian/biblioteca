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
		}
		
		// Consulta por ID do LIVRO
		if (($prTipoConsulta == 0) and ($ConsultaGeral == false)) {
			$filtro = " WHERE IDLIVRO = $prInfoConsulta";
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
		
		$sql = "SELECT * FROM TLIVROS ".$filtro;
		$resultadoSqlCons = $this->connection->query($sql);
		if ($resultadoSqlCons !== false && $resultadoSqlCons->num_rows > 0) {
			while($row = $resultadoSqlCons->fetch_assoc()){	
				$retornoConsulta[] = array(
					"idlivro"       => $row["IDLIVRO"],
					"nomelivro"     => $row["NOMELIVRO"],
					"nomeautor"     => $row["NOMEAUTOR"],
					"qtde"          => $row["QTDE"],
					"genero"        => $row["GENERO"],
					"sinopse"       => $row["SINOPSE"],
					"cadastroativo" => $row["CADASTROATIVO"]
					
				);
			}
			return $retornoConsulta;
		}            
        
    }
	
	public function InsertEhUpdateLivros($prIdLivro, $prNomeLivro, $prNomeAutor, $prGenero, $prQtde, $prSinopse, $prCadastroAtivo) {
		if (!empty(trim($prIdLivro))) {
			$AtualizaRegistro = true;
		} else {
			$AtualizaRegistro = false;
		}
		
		if ($AtualizaRegistro == true) {
			$sqlAux = "SELECT * FROM TLIVROS WHERE IDLIVRO = $prIdLivro";
			$resultadoSqlAux = $this->connection->query($sqlAux);
            
			if ($resultadoSqlAux !== false && $resultadoSqlAux->num_rows > 0) {
				$sqlCad = "UPDATE TLIVROS SET NOMELIVRO = '$prNomeLivro', NOMEAUTOR = '$prNomeAutor', GENERO = $prGenero,".
				"QTDE = $prQtde, SINOPSE = '$prSinopse', CADASTROATIVO = $prCadastroAtivo WHERE IDLIVRO = $prIdLivro";
				$retornoSqlCad = $this->connection->query($sqlCad);
				
				return "Registro atualizado com sucesso!";
			} else {
				return "Livro não encontrado para atualização!";
			}
				
		} else {
			if (trim($prNomeLivro) !== '' and trim($prNomeAutor) !== '' and trim($prGenero) !== '' and trim($prQtde) !== '' and trim($prSinopse) !== '') {
				$sqlcad = "INSERT INTO tlivros(nomelivro, nomeautor, genero, qtde, sinopse, cadastroativo) VALUES ('$prNomeLivro', '$prNomeAutor', '$prGenero', '$prQtde', '$prSinopse', true)";
				$retornoSql = $this->connection->query($sqlcad);
				return "Registro inserido com sucesso!";
			}		
		}	
	}
}

?>