<?php

interface PersisteCredencial {
	function insereUsuario($login, $senha, $nome);
	function getSenha($login);
}

class Credencial {
	private $persistencia;
	
	function __construct(PersisteCredencial $persistencia){
		$this->persistencia = $persistencia;
	}
	
	function confereLoginSenha($login, $senha) {
		$senhabd = $this->persistencia->getSenha($login);
		if ($senhabd != NULL && $senhabd == $senha){
			return TRUE;
		}
		return FALSE;
	}

	function insereLoginSenha($login, $senha, $nome) {
		return $this->persistencia->insereUsuario($login, $senha, $nome);
	}
}

?>