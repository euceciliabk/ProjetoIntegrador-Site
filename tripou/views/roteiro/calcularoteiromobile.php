<?php

$resposta = array();

$latitude_u = trim($_GET["latitude_u"]);
$longitude_u = trim($_GET["longitude_u"]);
$tempo_disp = (int)trim($_GET["tempo_disp"]);

chdir("../../");
require_once "controle.php";


$controleRoteiro = criaControleRoteiro();
$ids = $controleRoteiro->calculaRoteiro($latitude_u, $longitude_u, $tempo_disp);

if ($ids == NULL) {
    $resposta['sucesso'] = 0;
    $resposta['erro'] = "Não foi possível calcular o roteiro";
}
else{
    $resposta['sucesso'] = 1;
    $resposta['idpontos'] = $ids; 
}


echo json_encode($resposta);


?>