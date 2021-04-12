<?php

	require_once "modelo.php";
	require_once "usuario/sessao.php";

	class ControlePonto {
		private $persistencia;
		
		function __construct(PersistePonto $persistencia) {
			$this->persistencia = $persistencia;
		}
		
		function getPontos(){
			return array_reverse ($this->persistencia->carregaPontos());
		}

		function getPonto($id){
			return $this->persistencia->carregaPonto($id);
		}
		
		function inserePonto($texto, $nome, $avaliacao, $local, $quanto, $tempo, $latitude, $longitude, $foto) { //***
			error_log("Inserindo ponto");
			$sessao = new Sessao();
			$quem = $sessao->getLogin();
			$quando = date("Y-m-d H:i:s");
			$ponto = criaPonto($quem, 0, $quando, $texto, $nome, $avaliacao, $local, $quanto, $tempo, $latitude, $longitude, $foto);
			return $this->persistencia->salvaPonto($ponto);
		}

		function removePonto($quem, $quando, $texto, $nome, $avaliacao, $local, $quanto, $tempo, $latitude, $longitude, $foto) {
			$sessao = new Sessao();
			$login = $sessao->getLogin();
			if ($login == $quem) {
				$ponto = criaPonto($quem,0, $quando, "", "", "", "", "", "", "", "", "");
				$this->persistencia->removePonto($ponto);
			}
		}

		function removePontoTimeStamp($quem, $quando) {
			$sessao = new Sessao();
			$login = $sessao->getLogin();
			if ($login == $quem) {
				$ponto = criaPonto($quem,0, $quando, "", "", "", "", "", "", "", "", "");
				$this->persistencia->removePonto($ponto);
			}
		}
	}
	
?>