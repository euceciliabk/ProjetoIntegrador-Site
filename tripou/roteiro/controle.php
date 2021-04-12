<?php

	require_once "modelo.php";
	require_once "usuario/sessao.php";
	require_once "ponto/controle.php";
	

	class ControleRoteiro {
		private $persistencia;
		
		function __construct(PersisteRoteiro $persistencia) {
			$this->persistencia = $persistencia;
		}
		
		function getRoteiros($usuid){
			return array_reverse ($this->persistencia->carregaRoteiros($usuid));
		}
		
		function insereRoteiro($idpontos) { //***
			$sessao = new Sessao();
			$quem = $sessao->getLogin();
			$data = date("Y-m-d H:i:s");
			$idpontosarray = explode(',', $idpontos);
			$roteiro = criaRoteiro($quem, $idpontosarray);
			$result = $this->persistencia->salvaRoteiro($roteiro);
			return $result;
		}

		/*  
		function getCoordenadas($cidade, $rua, $estado) {
			$endereco = urlencode($cidade.','.$rua.','.$estado);
			$url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=Brazil";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response);
			$status = $response_a->status;

			if ( $status == 'ZERO_RESULTS' )
			{
				return FALSE;
			}
			else
			{
				$return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
				return $return;
			}
		}

		function getDistanciaTempo ($lat1, $lat2, $long1, $long2){
			$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pt-PT";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($ch);
			curl_close($ch);
			$response_a = json_decode($response, true);
			$dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
			$time = $response_a['rows'][0]['elements'][0]['duration']['text'];

    		return array('distance' => $dist, 'time' => $time);
		}
		*/

		function calculaDistancia($lat1, $lon1, $lat2, $lon2, $unit) {

			if (($lat1 == $lat2) && ($lon1 == $lon2)) {
			  return 0;
			}
			else {
			  $theta = $lon1 - $lon2;
			  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
			  $dist = acos($dist);
			  $dist = rad2deg($dist);
			  $miles = $dist * 60 * 1.1515;
			  $unit = strtoupper($unit);
		  
			  if ($unit == "K") {
				return ($miles * 1.609344);
			  } else if ($unit == "N") {
				return ($miles * 0.8684);
			  } else {
				return $miles;
			  }
			}
		}

		function cmp($a, $b) {
			return ($a["dist"] - $b["dist"]);
		}

		function calculaRoteiro($lat, $lon, $temp_disp) {
			$controlePonto = criaControlePonto();
			$pontos = $controlePonto->getPontos();

			//$ponto = $pontos[1];

			$latitude_u  = floatval($lat);
			$longitude_u  = floatval($lon);

			//$latitude = -20.196474256454785;
			//$longitude = -40.21911072744741;

			//$latitude = $ponto['latitude'];
			//$longitude = $ponto['longitude'];


			//$dist = $this->calculaDistancia($latitude, $longitude, $latitude_u, $longitude_u, "K");
			
			//return //lista do roteiro

			

			$distancias = array();

			$pontoids=array();

			if($pontos!=NULL){
				foreach($pontos as $ponto) {
					$latitude = $ponto['latitude'];
					$longitude = $ponto['longitude'];
					$tempo = $ponto['tempo'];
					//error_log("latitude: ", 0);
					//error_log(strval($latitude), 0);
					//error_log("longitude: ", 0);
					//error_log(strval($longitude), 0);
					$dist = $this->calculaDistancia($latitude, $longitude, $latitude_u, $longitude_u, "K");
					$ponto_dist['ponto'] = $ponto;
					$ponto_dist['dist'] = $dist;
					array_push($distancias, $ponto_dist);
				}
				usort($distancias, array($this, "cmp"));
				
				$soma_tempo = 0;
				$indice = 0;
				$pontos_rot = array();

				//$size = sizeof($distancias);
				//error_log("size: ", 0);
				//error_log($size, 0);
				$temp_disp_seg = $temp_disp * 60;

				while ($soma_tempo <= $temp_disp_seg && $indice<sizeof($distancias)) {
					$timestamp  = strval($distancias[$indice]['ponto']['tempo']);
					$nome  = $distancias[$indice]['ponto']['nome'];

					//error_log("nome: ", 0);
					//error_log($nome, 0);
					//error_log("timestamp: ", 0);
					//error_log($timestamp, 0);

					$parsed = date_parse($timestamp); //pega tempo gasto na visitação de um ponto
					$seconds = $parsed['second']; 
					$tempo = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']; //transformando o tempo para segundos

					//error_log("tempo: ", 0);
					//error_log($tempo, 0);

					$soma_tempo = $soma_tempo + $tempo;
					error_log($soma_tempo, 0);
					if($soma_tempo <= $temp_disp_seg){
						array_push($pontos_rot, $distancias[$indice]['ponto']);
					}
					$indice = $indice+1;

				  //percorrer lista de pontos e salvar eles na lista do roteiro do usuário
				}
				
				foreach($pontos_rot as $ponto) {
					array_push($pontoids,$ponto['idponto']);
					//error_log("pontoids: ", 0);
					//error_log(implode(', ', $pontoids), 0);

				}
				$this->insereRoteiro(implode(', ', $pontoids));
				
			}else{
				error_log("Nenhum ponto cadastrado.", 0);
			}
			return $pontoids;
		}

		

		
		function removeRoteiro($quem, $idroteiro) {
			$sessao = new Sessao();
			$login = $sessao->getLogin();
			if ($login == $quem) {
				$this->persistencia->removeRoteiro($idroteiro);
			}
		}
	}
	
?>