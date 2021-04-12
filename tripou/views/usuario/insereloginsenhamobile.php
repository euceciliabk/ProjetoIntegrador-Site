<?php

$resposta = array();

$nome = trim($_POST["nome"]);
$login = trim($_POST["login"]);
$senha = trim($_POST["senha"]);

chdir("../../");
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$resultado = $controleUsuario->insereLoginSenhaMobile($login, $senha, $nome);

if ($resultado == false) {
    $resposta['sucesso'] = 0;
    $resposta['erro'] = "Não foi possível efetuar o cadastro";
}
else{
    $resposta['sucesso'] = 1;
}


echo json_encode($resposta);

?>