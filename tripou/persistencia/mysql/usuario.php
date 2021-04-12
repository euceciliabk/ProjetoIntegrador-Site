<?php

require_once "usuario/credencial.php";
require_once "conexao.php";

class PersistenciaUsuario implements PersisteCredencial {
	private $persistencia;
	
	function __construct() {
		$this->persistencia = getConexao();
	}
	
	function criaTabelaUsuarios() {
		$query = "CREATE TABLE IF NOT EXISTS usuario (
			login VARCHAR(16) NOT NULL UNIQUE,
			senha VARCHAR(128) NOT NULL,
			idusuario INT NOT NULL AUTO_INCREMENT,
			PRIMARY KEY (idusuario)
		)";
		$result = $this->persistencia->query($query);
	}

	function insereUsuario($login, $senha) {
		$query = "INSERT INTO usuario (login, senha) VALUES ('$login', '$senha')";
		$result = $this->persistencia->query($query);
	}

	function getSenha($login){
		$query = "SELECT senha FROM usuario WHERE
		login='$login'";
		$result = $this->persistencia->query($query);
		$senha = NULL;

		if ($result && $result->num_rows > 0) {
			$senha = $result->fetch_assoc()['senha'];
		}
		return $senha;
	}
	
	function carregaUsuarios() {
		global $query;
		$query = "SELECT * FROM usuario";
		$result = $this->persistencia->query($query);
		$usuarios = array();

		if ($result && $result->num_rows > 0){
			while ($row = $result->fetch_assoc()) {
			//while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$usuarios[$row['login']] = $row['senha'];
			}
		}
		else{
			print_r("erro na consulta ao banco de dados");
		}
		return $usuarios;
	}
	
}

?>