<?php

require_once "mensagem/modelo.php";
require_once "persistencia/postgres/conexao.php";

class PersistenciaMensagem implements PersisteMensagem {
	private $persistencia;
	
	function __construct() {
		$this->persistencia = getConexao();
	}
	
	function criaTabelaMensagens() {
		$query = "CREATE TABLE IF NOT EXISTS mensagens (
			texto VARCHAR(128) NOT NULL,
			tempo TIMESTAMP NOT NULL,
			id serial PRIMARY KEY,
			usuid INT NOT NULL,
			FOREIGN KEY (usuid) REFERENCES usuarios(id)
		)";
		$result = pg_query($this->persistencia, $query);
		return $result;
	}
	
	private function getUsuarioId($login){
		$query = "SELECT id FROM usuarios WHERE login='$login' LIMIT 1";
		$result = pg_query($this->persistencia, $query);
		$usuid = NULL;
		if ($result && pg_num_rows($result) > 0) {
			$usuid = pg_fetch_assoc($result, NULL)['id'];
		}
		return $usuid;
	}

	function removeMensagem($mensagem) {
		$usuid = $this->getUsuarioId($mensagem['quem']);
		$tempo = $mensagem['quando'];
		$query = "DELETE FROM mensagens WHERE usuid='$usuid' AND 
		tempo='$tempo'";
		return pg_query($this->persistencia, $query);
	}
	
	function salvaMensagem($mensagem) {
		$usuid = $this->getUsuarioId($mensagem['quem']);
		$result = NULL;
		if ($usuid) {
			$texto = $mensagem['texto'];
			$tempo = $mensagem['quando'];
			$query = "INSERT INTO mensagens (texto, tempo, usuid) VALUES ('$texto', '$tempo', '$usuid')";
			$result = pg_query($this->persistencia, $query);
		}
		return $result;
	}
	
	private function getLoginUsuario($usuid) {
		$query = "SELECT login FROM usuarios WHERE id='$usuid' LIMIT 1";
		$result = pg_query($this->persistencia, $query);
		$login = NULL;
		if ($result && pg_num_rows($result) > 0) {
			$login = pg_fetch_assoc($result, NULL)['login'];
		}
		return $login;
	}
	
	function carregaMensagens(){
		$query = "SELECT * FROM mensagens";
		$result = pg_query($this->persistencia, $query);
		$mensagens = array();
		if ($result && pg_num_rows($result) > 0){ //importante
			while ($row = pg_fetch_assoc($result, NULL)){
				$login = $this->getLoginUsuario($row['usuid']);
				$mensagem = criaMensagem($row['texto'], $login, $row['tempo']);
				array_push($mensagens, $mensagem);
			}
		}
		return $mensagens;
	}
	
}

?>