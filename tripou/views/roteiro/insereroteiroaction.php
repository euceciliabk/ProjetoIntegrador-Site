<?php
chdir("../../");
require_once "controle.php";
$controleRoteiro = criaControleRoteiro();
$controleRoteiro->insereRoteiro($_POST['idpontos']);

header("Location: ../../index.php");

?>