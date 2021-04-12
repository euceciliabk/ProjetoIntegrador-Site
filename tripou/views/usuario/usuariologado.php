<?php

require_once "controle.php";

$controleUsuario = criaControleUsuario();

$login = $controleUsuario->getLogin();

if (empty($login)) {
	require_once 'views/usuario/loginform.html';
	
} else{
	echo $login;
	echo ' <a href="views/usuario/logoutaction.php">logout</a>';
}
	
?>