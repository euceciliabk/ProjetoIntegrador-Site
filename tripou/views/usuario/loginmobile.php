<?php

$resposta = array();

$login = trim($_POST["login"]);
$senha = trim($_POST["senha"]);

chdir("../../");
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$resultado = $controleUsuario->loginMobile($login, $senha);

if ($resultado == true) {
    $resposta['sucesso'] = 1;
}
else{
    $resposta['sucesso'] = 0;
    $resposta['erro'] = "O usuário ou senha não confere";
}


echo json_encode($resposta);

?>