<?php
	chdir("../../");
    require_once "controle.php";
	$controlePonto = criaControlePonto();
	$ponto = $controlePonto->getPonto($_GET['id']);
	
    $conteudo = $ponto['conteudofoto'];
    $tipo = $ponto['tipofoto'];

    header("Content-type: $tipo");
    print base64_decode($conteudo);

?>
 