<?php

require_once "usuario/credencial.php";
require_once "conexao.php";

class PersistenciaUsuario implements PersisteCredencial {
	private $persistencia;
	
	function __construct() {
		$this->persistencia = getConexao();
	}

	function insereUsuario($login, $senha, $nome) {
		$query = "INSERT INTO usuario (login, senha, nome, ativo) VALUES ('$login', '$senha', '$nome', '0')";
		$result = pg_query($this->persistencia, $query);
		return $result;
	}

	function getSenha($login){
		$query = "SELECT senha FROM usuario WHERE
		login='$login'";
		$result = pg_query($this->persistencia, $query);
		$senha = NULL;

		if ($result && pg_num_rows($result) > 0) {
			$senha = pg_fetch_assoc($result, NULL)['senha'];
		}
		return $senha;
	}
	
	function carregaUsuarios() {
		global $query;
		$query = "SELECT * FROM usuario";
		$result = pg_query($this->persistencia, $query);
		$usuarios = array();

		if ($result && pg_num_rows($result) > 0) {
			while ($row = pg_fetch_assoc($result, NULL)) {
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