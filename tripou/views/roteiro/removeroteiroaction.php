<?php
chdir("../../");
require_once "controle.php";
$controleRoteiro = criaControleRoteiro();
$controleRoteiro->removeRoteiro($_POST['quem'], $_POST['roteiro']);


header("Location: /tripou/");
?>