<?php

chdir("../../");
require_once "controle.php";
$controleUsuario = criaControleUsuario();
$controleUsuario->logout();

header("Location: /");

?>