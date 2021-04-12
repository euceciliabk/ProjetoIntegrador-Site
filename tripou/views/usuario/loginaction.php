<?php

chdir("../../");
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$controleUsuario->login($_POST["login"], $_POST["senha"]);

header("Location: /");

?>

