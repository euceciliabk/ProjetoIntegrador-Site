<?php

$resposta = array();

$login = trim($_POST["login"]);
$senha = trim($_POST["senha"]);
$texto = trim($_POST["texto"]);
$nome = trim($_POST["nome"]);
$avaliacao = trim($_POST["avaliacao"]);
$local = trim($_POST["local"]);
$quanto = trim($_POST["quanto"]);
$tempo = trim($_POST["tempo"]);
$latitude = trim($_POST["latitude"]);
$longitude = trim($_POST["longitude"]);
$foto = $_FILES["foto"];

chdir("../../");
require_once "controle.php";

$controleUsuario = criaControleUsuario();
$resultado = $controleUsuario->loginMobile($login, $senha);

if ($resultado == false) {
    $resposta['sucesso'] = 0;
    $resposta['erro'] = "O usuário ou senha não confere";
}
else{
    
    $controlePonto = criaControlePonto();
    $resultado = $controlePonto->inserePonto($texto, $nome, $avaliacao, $local, $quanto, $tempo, $latitude, $longitude, $foto);

    if ($resultado == false) {
        $resposta['sucesso'] = 0;
        $resposta['erro'] = "Não foi possível cadastrar o ponto";
    }
    else{
        $resposta['sucesso'] = 1;
    }
}


echo json_encode($resposta);


?>