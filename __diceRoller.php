<?php


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

strtoupper($dice);
$explodedDice = explode("D", $dice);

if(count($explodedDice) != 2 || !is_numeric($explodedDice[0]) || !is_numeric($explodedDice[1]))
{
	echo  "<h1>Error!</h1> The dice must have to be formated as <numberOfDices>D<sidesOnTheDice>. <br>	eg. 1D20";
	exit(0);
}

for($i = 0; $i < $explodedDice[0]; $i++)
	$rolls[$i] = mt_rand(1, $explodedDice[1]);

$messHtml = "<b>".$player."</b> rolled <b>".$explodedDice[0]."</b> dices of <b>".$explodedDice[1]."</b> sides and scored:<br><b>".implode(", ", $rolls)."</b>";
$mess = $player." rolled ".$explodedDice[0]." dices of ".$explodedDice[1]." sides and scored:\n".implode(", ", $rolls);
echo($messHtml);
mail('sht.mails@gmail.com,aguivico@gmail.com,enric2ndai@gmail.com,ajavimes@gmail.com,asiria86@gmail.com', 'Dice Roller!', $mess);
	
?>