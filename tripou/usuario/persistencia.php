<?php

require_once "usuario/credencial.php";

class Persistencia implements PersisteCredencial {
	private $arquivo;
	function __construct() {
		$this->arquivo = getcwd() . "/usuario/usuarios.json";
	}
	
	function carregaUsuarios() {
		$jsonString = file_get_contents($this->arquivo);
		$usuarios = json_decode($jsonString, true);
		return $usuarios;
	}
	
	function salvaUsuarios($usuarios) {
		$jsonString = json_encode($usuarios);
		file_put_contents($this->arquivo, $jsonString);
	}

}

?>