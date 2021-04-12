<?php
chdir("../../");
require_once "controle.php";
$controleRoteiro = criaControleRoteiro();
$controleRoteiro->calculaRoteiro($_POST['latitude_u'], $_POST['longitude_u'], $_POST['tempo_disp']);

header("Location: ../../index.php");

?>