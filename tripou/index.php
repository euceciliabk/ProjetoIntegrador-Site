<!DOCTYPE html>
<html>

<head>
	<title> Tripou </title>
</head>

<body>

	<center>
	<h1><img width="200px" src="imagens/logo.jpeg"  /></h1>
	<?php require_once 'views/usuario/usuariologado.php'; ?>
	
	<?php require_once 'views/ponto/insereponto.php'; ?>
	<br>
	<?php require_once 'views/ponto/listaponto.php'; ?>

	<?php require_once 'views/roteiro/insereroteiro.php'; ?>
	<br>
	<?php require_once 'views/roteiro/listaroteiro.php'; ?>
	<br>
	<?php require_once 'views/roteiro/calcularoteiro.php'; ?>
	
	</center>
	
</body>

</html>

