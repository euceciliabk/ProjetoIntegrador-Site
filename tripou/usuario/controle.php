<?php

require_once "credencial.php";
require_once "sessao.php";

class ControleUsuario {
	
	private $sessao;
	private $credencial;
	
	function __construct(PersisteCredencial $persistencia) {
		$this->sessao = new Sessao();
		$this->credencial = new Credencial($persistencia);
	}

	function getLogin() {
		$login = $this->sessao->getLogin();
		return $login;
	}

	function login($login, $senha){
		if ($this->credencial->confereLoginSenha($login, $senha)) {
			$this->sessao->login($login);
		}
		//$this->sessao->login($login);
	}

	function loginMobile($login, $senha){
		if ($this->credencial->confereLoginSenha($login, $senha)) {
			$this->sessao->login($login);
			return true;
		}
		else{
			return false;
		}
	}

	function logout() {
		$this->sessao->logout();
	}

	function insereLoginSenha($login, $senha, $nome) {
		$this->credencial->insereLoginSenha($login, $senha, $nome);
	}

	function insereLoginSenhaMobile($login, $senha, $nome) { 
		return $this->credencial->insereLoginSenha($login, $senha, $nome);
		
	}
}

?>