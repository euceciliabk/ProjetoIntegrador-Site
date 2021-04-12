<?php
chdir("../../");
require_once "controle.php";
$controlePonto = criaControlePonto();
$controlePonto->inserePonto($_POST['texto'], $_POST['nome'], $_POST['avaliacao'], $_POST['local'], $_POST['quanto'], $_POST['tempo'], $_POST['latitude'], $_POST['longitude'], $_FILES['foto']);
//$controlePonto->calculaRoteiro($_POST['tempo'] ,$_POST['latitude'], $_POST['longitude']);
header("Location: ../../index.php");

?>