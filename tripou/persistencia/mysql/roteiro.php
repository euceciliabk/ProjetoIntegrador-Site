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
		$result = $this->persistencia->query($query);
		$usuid = NULL;
		if ($result && $result->num_rows > 0) {
			$usuid = $result->fetch_array(MYSQLI_ASSOC)['idusuario'];
		}
		return $usuid;
	}

	function removeRoteiro($idroteiro) { 

		$query = "DELETE FROM contem WHERE roteiro_idroteiro='$idroteiro'";
		$result = $this->persistencia->query($query);

		$query = "DELETE FROM roteiro WHERE idroteiro='$idroteiro'";
		$this->persistencia->query($query);
	}
	
	function salvaRoteiro($roteiro) { 
		$usuid = $this->getUsuarioId($roteiro['quem']); 
		$idpontos = $roteiro['idpontos'];
		$result = NULL;
		if ($usuid!=NULL) {
			$query = "INSERT INTO roteiro (usuario_idusuario) 
			VALUES ('$usuid')"; 
			$result = pg_query($this->persistencia, $query);
		}
		$idroteiro = $this->persistencia->insert_id; //last inserted id
		if($idroteiro!=NULL){
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
		$result = $this->persistencia->query($query);
		$login = NULL;
		if ($result && $result->num_rows > 0) {
			$login = $result->fetch_array(MYSQLI_ASSOC)['login'];
		}
		return $login;
	}
	
	function carregaRoteiros($quem){ 
		$usuid = $this->getUsuarioId($quem); 
		//print("userid");
		//print($usuid);
		$query = "SELECT * FROM roteiro WHERE usuario_idusuario='$usuid'";
		$result = $this->persistencia->query($query);
		$roteiros = array();
		if ($result && $result->num_rows > 0){ //importante
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){

				$idroteiro = $row['idroteiro'];

				//print("idroteiro");
				//print($idroteiro);

				$query2 = "SELECT * FROM contem WHERE roteiro_idroteiro='$idroteiro'";
				$result2 = $this->persistencia->query($query2);
				
				if ($result2 && $result2->num_rows > 0){
					$idpontos = array();
					while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
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