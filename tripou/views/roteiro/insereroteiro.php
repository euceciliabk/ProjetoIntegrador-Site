<?php

require_once "controle.php";

$controleUsuario = criaControleUsuario();

$login = $controleUsuario->getLogin();

if (!empty($login)) {
	require_once 'views/roteiro/insereroteiroform.html';
	
}
	
?>