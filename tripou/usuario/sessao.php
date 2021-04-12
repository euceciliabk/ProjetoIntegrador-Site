<?php

class Sessao {
	private $credencial;
	function __construct() {
		if(!isset($_SESSION)) { 
        	session_start(); 
		}
	}
	function getLogin() {
		if (array_key_exists("login", $_SESSION)){
			return $_SESSION["login"]; 
		}
		return 0; 
	}
	
	function login($login) {
		$_SESSION["login"] = $login;
	}
	
	function logout() {
		$_SESSION["login"] = "";
	}
}

?>