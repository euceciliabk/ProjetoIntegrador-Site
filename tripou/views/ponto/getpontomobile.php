<?php

$resposta = array();

$id = trim($_GET["id"]);

chdir("../../");
require_once "controle.php";
$controlePonto = criaControlePonto();
$ponto = $controlePonto->getPonto($id);
    

if ($ponto == NULL) {
    $resposta['sucesso'] = 0;
    $resposta['erro'] = "Não foi possível listar as informações do ponto";
}
else{
    $resposta['quem'] = $ponto['quem'];
    $resposta['quando'] = $ponto['quando'];
    $resposta['texto'] = $ponto['texto'];
    $resposta['nome'] = $ponto['nome'];
    $resposta['avaliacao'] = $ponto['avaliacao'];
    $resposta['local'] = $ponto['local'];
    $resposta['quanto'] = $ponto['quanto'];
    $resposta['tempo'] = $ponto['tempo'];
    $resposta['latitude'] = $ponto['latitude'];
    $resposta['longitude'] = $ponto['longitude'];
    $resposta['idponto'] = $ponto['idponto'];
    $resposta['conteudofoto'] = $ponto['conteudofoto'];
    $resposta['nomefoto'] = $ponto['nomefoto'];
    $resposta['tipofoto'] = $ponto['tipofoto'];
        
    $resposta['sucesso'] = 1;

}



echo json_encode($resposta);


?>