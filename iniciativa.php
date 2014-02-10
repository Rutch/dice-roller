<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: javiermartin
	 * Date: 01/10/14
	 * Time: 09:46
	 * To change this template use File | Settings | File Templates.
	 *
	 * Usage:
	 *
	 *		iniciativa.php?player=XXXX&enemies=Lobito,Caperucita,..&players=Atreyu,Gatsu..&onlyMaster=true|false
	 *
	 * Sólo es obligatoria la variable player. Players por defecto todos los que jugamos-
	 */

	error_reporting(E_ALL);

	//Dato mínimo para la partida
	if(!array_key_exists('player', $_GET)) 
		die('Faltan datos...muchos datos');

	//Archivo de configuración
	$emailsConfigFile = "emails.conf";

	//Verificamos variables
	$players = isset($_GET['players']) ? urldecode($_GET['players']) : "";
	$onlyMaster = isset($_GET['onlyMaster']) ? $_GET['onlyMaster'] : "";
	$enemies = isset($_GET['enemies']) ? urldecode($_GET['enemies']) : "";
	$SEND_TO = isset($_GET['debug']) ? explode(",", $_GET['debug']) : file($emailsConfigFile, FILE_IGNORE_NEW_LINES);
	

	//Instanciamos clase
	$rpg = new RPGThrowingInitiative($_GET['player'], $players, $enemies, $onlyMaster);
	
	//Iniciativa de jugadores	
	$playersInitiative = $rpg->throwingInitiative('players');	
	
	//Comprobamos si existen enemigos y lanzamos iniciativa
	if($enemies == ""){
		$enemiesInitiative = array();
	}else{
		$enemiesInitiative = $rpg->throwingInitiative('enemies');	
	}
	
	//Obtenemos la tabla de iniciativa ordenada
	$initiativeTable = $rpg->orderingInitiative($playersInitiative,$enemiesInitiative);	

	//Lanzamos emilio
	$mail = $rpg->sendData($initiativeTable, $SEND_TO);

	//Matamos proceso
	$rpg = null;	
	
	//Clase de iniciativa
	class RPGThrowingInitiative{
		
		//Variables, todas privadas para no llamarlas desde fuera. Chorrada
		private $players;
		private $player;
		private $enemies;
		private $arrayPlayersInitiative = array();
		private $arrayEnemiesInitiative = array();
		private $orderingInitiative = "<table><tr><td>Jugador/Enemigo</td><td>&nbsp;&nbsp;&nbsp;</td><td>Tirada</td></tr>\n\r";
		private $onlyMaster = false;

		/*
		 * Contructor de la clase con datos mínimos
		 * @param string $player
		 * @param string $players
		 * @param string $players
		 * @param string $onlyMaster
		 * Asignamos variables y convertimos string to array y string to boolean
		 */
		public function __construct($player, $players, $enemies, $onlyMaster){

			$this->player = $player;			
						
			if($players == ""){
				$this->players = array("Javi","Adam","Alex","Fran","Rutch","Enric","Germán");					
			}else{
				$this->players = explode(",",$players);
			}

			if($enemies == ""){
				$this->enemies = array();
			}else{
				$this->enemies = explode(",",$enemies);
			}

			if($onlyMaster == ""){
				$this->onlyMaster = false;
			}else{
				$this->onlyMaster = $onlyMaster;
			}

		}

		/*
		 * Según quien lo pida se crea la tirada de iniciativa para jugadores o enemigos
		 * @param string $who según sea enemies or players
		 * return array con los enemigos/jugadores y su iniciativa		 
		 */	
		public function throwingInitiative( $who ){

			switch ($who) {
				case 'players':
					//Contamos nº de jugadores
					$totalPlayers = count($this->players);
					
					//Creamos array para almacenar datos
					$arrayPlayersInitiative = array();

					//Bucle, recorremos, asignamos al jugador la iniciativa
					for($i=0; $i < $totalPlayers; $i++){
						
						$playerName = $this->players[$i];
						$arrayPlayersInitiative[$playerName] = mt_rand(1,20);
					}
					
					return $arrayPlayersInitiative;
				
				break;
				
				case 'enemies':
					//Contamos nº de enemigos
					$totalEnemies= count($this->enemies);
					
					//Creamos array para almacenar datos
					$arrayEnemiesInitiative = array();

					//Bucle, recorremos, asignamos al jugador la iniciativa
					for($i=0; $i < $totalEnemies; $i++){
						
						$enemyName = $this->enemies[$i];
						$arrayEnemiesInitiative[$enemyName] = mt_rand(1,20);
					}
					
					return $arrayEnemiesInitiative;
				break;	
			}


		}

		/*
		 * Imprime una tabla HTML con los datos
		 * @param array $players 
		 * @param array $enemies
		 * return string
		 */	
		public function orderingInitiative( $players, $enemies ){

			//Unimos arrays
			$mergePlayerAndEnemies = array_merge($players, $enemies);
			//Shuffle antes del ordenado, ya q los casos de empate se 'ordenan' según aparición en el array, de esta forma ese 'orden' es aleatorio
			$this->shuffle_assoc($mergePlayerAndEnemies);
			//Ordenamos por valor
			arsort($mergePlayerAndEnemies);

			//Recorremos array y creamos tabla con datos
			foreach ($mergePlayerAndEnemies as $key => $value) {

				$this->orderingInitiative .= "<tr><td align='center'>". $key ."</td><td>&nbsp;&nbsp;&nbsp;</td><td align='center'> ".$value. "</td></tr>\n\r";
			}
			$this->orderingInitiative .= "</table>";

			return $this->orderingInitiative;
		}

		/*
		 * Envía datos según scripts del Rutch
		 * @param string $msg
		 * @param array $SENDTO		 
		 */	
		public function sendData($msg , $SENDTO ){
						
			$MASTER = $SENDTO[0];			
			$headers = "From: DAIGEONS & DAIGONS <diceRoller@tupajar.com>\n";
			$headers .= "Reply-To: DAIGEONS & DAIGONS <no-reply@tupajar.com>\n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1";

			if((boolean)$this->onlyMaster == true){
				mail($MASTER, 'Iniciativa secreta de '.$this->player, $msg, $headers);
				mail(implode(',', $SENDTO), 'Iniciativa secreta de '.$this->player, "Parece que <b>".$this->player."</b> ha tirado iniciativa de forma misteriosa solo para los ojos del Master...", $headers);				
			}else{
				mail(implode(',', $SENDTO), 'Iniciativa de '.$this->player, $msg, $headers);
			}
		}

		/**
		 * shuffle para arrays asociativas....
		 * @param Array $array El array a shuflear :)
		 */
		private function shuffle_assoc(&$array) 
		{
	        $keys = array_keys($array);

	        shuffle($keys);

	        foreach($keys as $key)
	            $new[$key] = $array[$key];

	        $array = $new;

	        return true;
	    }

		public function __destruct(){
			$this->player;
			$this->players;
			$this->enemies;
			$this->onlyMaster;
		}


	}
