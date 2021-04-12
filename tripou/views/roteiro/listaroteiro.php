<?php
	require_once "controle.php";
	require_once "usuario/sessao.php";

	$controleRoteiro = criaControleRoteiro();

	$sessao = new Sessao();
	$login = $sessao->getLogin();

	$roteiros = $controleRoteiro->getRoteiros($login);
	
	//echo $login;

	if($roteiros!=NULL){
		echo "Lista de Roteiros do Usuário";
		//echo var_dump($roteiros);
		foreach($roteiros as $roteiro) {
			echo "<br><div>";
			//echo $roteiro['quem'];
			echo "idroteiro: ".$roteiro['idroteiro'];
			$idpontos =$roteiro['idpontos'];
			echo " - idpontos: ".implode(', ', $roteiro['idpontos']);
			//foreach($idpontos as $idponto) {
			//	echo " - idponto: ".$idponto;
			//}
			echo "<br>";
			require 'views/roteiro/removeroteiroform.php';
			echo "</div>";
		}
	}else{
		echo "Nenhum roteiro cadastrado.";
	}
?>