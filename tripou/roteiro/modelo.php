<?php

interface PersisteRoteiro {
	function carregaRoteiros($usuid);
	function salvaRoteiro($roteiro);
	function removeRoteiro($roteiro);
}

function criaRoteiro($quem, $idpontos) { //*** 
	$roteiro = array();
	$roteiro ['quem'] = $quem;
	$roteiro ['idpontos'] = $idpontos;
	$roteiro ['idroteiro'] = 0;
	return $roteiro;
}

?>