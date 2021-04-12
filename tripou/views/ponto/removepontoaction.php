<?php
chdir("../../");
require_once "controle.php";
$controlePonto = criaControlePonto();
$controlePonto->removePontoTimeStamp($_POST['quem'], $_POST
['quando']);


header("Location: /");
?>