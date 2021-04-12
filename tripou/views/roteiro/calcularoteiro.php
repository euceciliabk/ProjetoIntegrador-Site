<?php

require_once "controle.php";

$controleUsuario = criaControleUsuario();

$login = $controleUsuario->getLogin(); //TODO

if (!empty($login)) {
	require_once 'views/roteiro/calcularoteiroform.html';
	
}
	
?>