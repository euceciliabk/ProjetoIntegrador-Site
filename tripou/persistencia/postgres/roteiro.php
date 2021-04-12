<?php


require_once "conexao.php";
require_once "roteiro/modelo.php";
require_once "usuario/sessao.php";



class PersistenciaRoteiro implements PersisteRoteiro { //
	private $persistencia;
	
	function __construct() {
		$this->persistencia = getConexao();
	}
	
	
	private function getUsuarioId($login){ //igual
		$query = "SELECT idusuario FROM usuario WHERE login='$login' LIMIT 1";
		$result = pg_query($this->persistencia, $query);
		$usuid = NULL;
		if ($result && pg_num_rows($result) > 0) {
			$usuid = pg_fetch_assoc($result, NULL)['idusuario'];
		}
		
		return $usuid;

	}

	function removeRoteiro($idroteiro) { 

		$query = "DELETE FROM contem WHERE roteiro_idroteiro='$idroteiro'";
		$result = pg_query($this->persistencia, $query);

		$query = "DELETE FROM roteiro WHERE idroteiro='$idroteiro'";
		$result = pg_query($this->persistencia, $query);
	}
	
	function salvaRoteiro($roteiro) { 
		$usuid = $this->getUsuarioId($roteiro['quem']); 
		$idpontos = $roteiro['idpontos'];
		$result = NULL;
		$idroteiro = NULL;

		if ($usuid!=NULL) {
			$query = "INSERT INTO roteiro (usuario_idusuario, data) 
			VALUES ('$usuid', NOW()) RETURNING idroteiro"; 
			$result = pg_query($this->persistencia, $query);
			$row = pg_fetch_array($result);
			$idroteiro = $row['idroteiro'];
		}
		$result2 = NULL;
		//$idroteiro = $result['idroteiro'][0]; //last inserted id
		//$idroteiro = pg_last_oid ( $result);

		//$OID = pg_getlastoid($result);
		//$query = "select idroteiro from roteiro where OID=$OID";
		//$idres = pg_query($this->persistencia, $query);
		//$idroteiro = pg_result($idres,0,"idroteiro");

		error_log($idroteiro);

		if($idroteiro!=NULL){
			error_log("Oi");
			foreach($idpontos as $idponto) {
				$query = "INSERT INTO contem (roteiro_idroteiro, pontoturistico_idpontoturistico) 
				VALUES ('$idroteiro', '$idponto')"; 
				$result2 = pg_query($this->persistencia, $query);
			} 
		}
		return $result2;
	}
	
	private function getLoginUsuario($usuid) { //igual
		$query = "SELECT login FROM usuario WHERE idusuario='$usuid' LIMIT 1";
		$result = pg_query($this->persistencia, $query);
		$login = NULL;
		if ($result && pg_num_rows($result) > 0) {
			$login = pg_fetch_assoc($result, NULL)['login'];
		}
		return $login;
	}
	
	function carregaRoteiros($quem){ 
		$usuid = $this->getUsuarioId($quem); 
		//print("userid");
		//print($usuid);
		$query = "SELECT * FROM roteiro WHERE usuario_idusuario='$usuid'";
		$result = pg_query($this->persistencia, $query);
		$roteiros = array();
		if ($result && pg_num_rows($result) > 0) {
			while ($row = pg_fetch_assoc($result, NULL)){

				$idroteiro = $row['idroteiro'];

				//print("idroteiro");
				//print($idroteiro);

				$query2 = "SELECT * FROM contem WHERE roteiro_idroteiro='$idroteiro'";
				$result2 = pg_query($this->persistencia, $query2);
				
				if ($result2 && pg_num_rows($result2) > 0) {
					$idpontos = array();
					while ($row2 = pg_fetch_assoc($result2, NULL)){
						//print("- idponto: ");
						$idponto = $row2['pontoturistico_idpontoturistico'];
						//print($idponto);
						array_push($idpontos, $idponto);
					}
					//print("- array idpontos: ");
					//print_r($idpontos);
					$roteiro = criaRoteiro ($quem, $idpontos);
					$roteiro ['idroteiro']=$idroteiro;
					array_push($roteiros, $roteiro);
				}
			}
		}else{
			print("Não foram encontrados roteiros.");
		}
		return $roteiros;
	}
	
}

?>