<?php
	require_once "controle.php";
	$controlePonto = criaControlePonto();
	$pontos = $controlePonto->getPontos();
	
	echo "Lista de Pontos Turísticos Cadastrados";

	foreach($pontos as $ponto) {
		echo "<br><div>";
		echo $ponto['quem'] . "(". $ponto['nome'] . ")<br>";
		echo $ponto['texto'];
		$id = $ponto['idponto'];
		//echo "<a href='views/ponto/baixararquivo.php?id=$id'>Download Foto</a>";
		require 'views/ponto/baixaarquivoform.php';
		require 'views/ponto/removepontoform.php';
		echo "</div>";
	}
?>