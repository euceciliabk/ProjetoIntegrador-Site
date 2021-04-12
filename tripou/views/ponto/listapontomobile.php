<?php

$resposta = array();

chdir("../../");
require_once "controle.php";

$controlePonto = criaControlePonto();
$pontos = $controlePonto->getPontos();
    

if ($pontos == NULL) {
    $resposta['sucesso'] = 0;
    $resposta['erro'] = "Não existem pontos turísticos cadastrados";
}
else{
    $ids = array();
    foreach ($pontos as $ponto){
        array_push($ids, $ponto['idponto']);
    }
    $resposta['sucesso'] = 1;
    $resposta['idpontos'] = $ids; //checar

}



echo json_encode($resposta);


?>