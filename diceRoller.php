<?php

/**
 *	Usage:
 *		diceRoller.php?player=PlayerName&dice=1D20&onlyMaster=true&sort=true
 *
 */

$SEND_TO = 
[
	'sht.mails@gmail.com'			//Rutch
	//,'aguivico@gmail.com'			//Fran
	//,'enric2ndai@gmail.com'		//Enric
	//,'javimes@gmail.com'			//Javi
	//,'asiria86@gmail.com'			//Adam
	//,'ggcwebdesign@gmail.com'		//Germán
	//,'alreina87@gmail.com'		//Alex
	//,'cid_hispano@hotmail.com'	//Orma
];

$MASTER = 'sht.mails@gmail.com';

if (isset($argv[1])) 
	$player = $argv[1];
else  if (isset($_GET['player']))
	$player = $_GET['player'];
else
	$player = 'Someone';

if (isset($argv[2])) 
	$dice = $argv[2];
else  if (isset($_GET['dice']))
	$dice = $_GET['dice'];
else
	$dice = '1D20';

if (isset($argv[3])) 
	$onlyMaster = $argv[3];
else  if (isset($_GET['onlyMaster']))
	$onlyMaster = $_GET['onlyMaster'];
else
	$onlyMaster = false;

if (isset($argv[4])) 
	$sort = $argv[4];
else  if (isset($_GET['sort']))
	$sort = $_GET['sort'];
else
	$sort = false;

strtoupper($dice);
$explodedDice = explode("D", $dice);

if(count($explodedDice) != 2 || !is_numeric($explodedDice[0]) || !is_numeric($explodedDice[1]))
{
	echo  "<h1>Error!</h1> El dado debe tener el formato: &lt;CantidadDeDados&gt;<b>D</b>&lt;LadosDeLosDados&gt;. <br>	ejemplo: 1D20";
	exit(0);
}

for($i = 0; $i < $explodedDice[0]; $i++)
	$rolls[$i] = mt_rand(1, $explodedDice[1]);

$mess = "<h1><b>".$player."</b></h1> ha tirado <b>".$explodedDice[0]."</b> dados de <b>".$explodedDice[1]."</b> caras y ha sacado:<br><h2><b>".implode(", ", $rolls)."</b></h2>";
echo($mess);

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1";

if($onlyMaster)
{
	mail($MASTER, 'Tirada secreta de '.$player, $mess, $headers);
	mail(implode(',', $SEND_TO), 'Tirada secreta de '.$player, "Parece que ".$player." ha tirado los dados de forma misteriosa solo para los ojos del Master...", $headers);
}
else
{
	mail(implode(',', $SEND_TO), 'Tirada de '.$player, $mess, $headers);
}

?>