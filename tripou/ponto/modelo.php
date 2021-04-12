<?php

interface PersistePonto {
	function carregaPontos();
	function salvaPonto($ponto);
	function removePonto($ponto);
}

function criaPonto($quem, $idponto, $quando, $texto, $nome, $avaliacao, $local, $quanto, $tempo, $latitude, $longitude, $foto) { //*** 
	error_log("Criando ponto");
	$ponto = array();
	$ponto ['quem'] = $quem;
	$ponto ['quando'] = $quando;
	$ponto ['texto'] = $texto;
	$ponto ['nome'] = $nome;
	$ponto ['avaliacao'] = $avaliacao;
	$ponto ['local'] = $local;
	$ponto ['quanto'] = $quanto;
	$ponto ['tempo'] = $tempo;
	$ponto ['latitude'] = $latitude;
	$ponto ['longitude'] = $longitude;
	$ponto ['idponto'] = $idponto;
	$ponto ['foto'] = $foto;
	return $ponto;
}

function criaPontoArquivo($quem, $idponto, $quando, $texto, $nome, $avaliacao, $local, $quanto, $tempo, $latitude, $longitude, $conteudofoto, $nomefoto, $tipofoto) { //*** 
	error_log("Criando ponto");
	$ponto = array();
	$ponto ['quem'] = $quem;
	$ponto ['quando'] = $quando;
	$ponto ['texto'] = $texto;
	$ponto ['nome'] = $nome;
	$ponto ['avaliacao'] = $avaliacao;
	$ponto ['local'] = $local;
	$ponto ['quanto'] = $quanto;
	$ponto ['tempo'] = $tempo;
	$ponto ['latitude'] = $latitude;
	$ponto ['longitude'] = $longitude;
	$ponto ['idponto'] = $idponto;
	$ponto ['conteudofoto'] = $conteudofoto;
	$ponto ['nomefoto'] = $nomefoto;
	$ponto ['tipofoto'] = $tipofoto;
	return $ponto;
}

?>