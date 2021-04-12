<?php

chdir("../../");
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$controleUsuario->insereLoginSenha($_POST["login"], $_POST["senha"], $_POST["nome"]);

header("Location: /");

?>