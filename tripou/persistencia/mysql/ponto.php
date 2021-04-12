<?php


require_once "conexao.php";
require_once "ponto/modelo.php";

class PersistenciaPonto implements PersistePonto { //
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

	function removePonto($ponto) { //remove ponto ***
		$usuid = $this->getUsuarioId($ponto['quem']);
		$quando = $ponto['quando'];
		$query = "DELETE FROM pontoturistico WHERE criador_idusuario='$usuid' AND 
		quando='$quando'";
		$this->persistencia->query($query);
	}
	
	function salvaPonto($ponto) { // salva ponto
		error_log("Salvando ponto");
		$usuid = $this->getUsuarioId($ponto['quem']); 
		$result = NULL;
		if ($usuid) {
			error_log("Entrou no IF");
			$quando = $ponto['quando'];
			$texto = $ponto['texto']; 
			$nome = $ponto['nome'];
			$avaliacao = $ponto['avaliacao'];
			$local = $ponto['local'];
			$quanto = $ponto['quanto'];
			$tempo_seg = $ponto['tempo'] * 60; //converte tempo do formulário que está em minutos para segundos
			$tempo = gmdate("H:i:s", $tempo_seg); //converte tempo em segundos para notação HH:MM:SS
			$latitude = $ponto['latitude'];
			$longitude = $ponto['longitude'];

			if ($ponto['foto'] == null) {
				error_log("Arquivo nulo");
			}
			$foto = $ponto['foto']["tmp_name"];
			$tamanho = $ponto['foto']["size"];
			$tipo    = $ponto['foto']["type"];
			$nome  = $ponto['foto']["name"];

			error_log("arquivo recebido");
			error_log($nome);

			if ( $foto != NULL ) { //MOD
				error_log("Lendo Arquivo");
				$fp = fopen($foto, "rb");
				$conteudo = fread($fp, $tamanho);
				$conteudo = addslashes($conteudo);
				fclose($fp); 
			}
			error_log("salvando no banco");
			
			$query = "INSERT INTO pontoturistico (criador_idusuario, quando, descricao, nome, avaliacao, localizacao, preco, tempo, latitude, longitude, foto, foto_nome, foto_tipo) 
			VALUES ('$usuid', '$quando','$texto','$nome', '$avaliacao', '$local', '$quanto','$tempo', '$latitude', '$longitude', '$conteudo', '$nome', '$tipo')"; // atributos da tabela ponto turistico
			$result = $this->persistencia->query($query);
			error_log($result);
		}
			return $result;
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
	
	function carregaPontos(){ //carrega pontos
		$query = "SELECT * FROM pontoturistico";
		$result = $this->persistencia->query($query);
		$pontos = array();
		if ($result && $result->num_rows > 0){ //importante
			while ($row = $result->fetch_array(MYSQLI_ASSOC)){
				$login = $this->getLoginUsuario($row['criador_idusuario']);
				$ponto = criaPontoArquivo( $login, $row['idpontoTuristico'], $row['quando'], $row['descricao'], $row['nome'], $row['avaliacao'], $row['localizacao'], $row['preco'], $row['tempo'], $row['latitude'], $row['longitude'], $row['foto'], $row['foto_nome'], $row['foto_tipo']);
				//$quem, $quando, $texto, $nome, $avaliacao, $local, $quanto, $tempo
				array_push($pontos, $ponto);
			}
		}
		return $pontos;
	}

	function carregaPonto($id){ 
		$query = "SELECT * FROM pontoturistico WHERE idpontoTuristico = '$id'";
		$result = $this->persistencia->query($query);

		if ($result && $result->num_rows > 0){ 
			$row = $result->fetch_assoc();
			$login = $this->getLoginUsuario($row['criador_idusuario']);
			$ponto = criaPontoArquivo( $login, $row['idpontoTuristico'], $row['quando'], $row['descricao'], $row['nome'], $row['avaliacao'], $row['localizacao'], $row['preco'], $row['tempo'], $row['latitude'], $row['longitude'], $row['foto'], $row['foto_nome'], $row['foto_tipo']);
		
		}
		return $ponto;
	}
	
}

?>