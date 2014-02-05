###########################################
#	DICE ROLLER - DAIGEONS & DAIGONS
###########################################

[+] Debe existir un archivo 'emails.conf' que debe contener los emails a los que se van a notificar las tiradas,
con un email por línea y dónde la primera línea debe contener el email del master de la partida.

[+] El servicio diceRoller.php acepta por GET los params siguientes:
	[-] player		Nombre del jugador que hace la tirada (se usará este nombre en el asunto del mail de notificación)
	[-] dice 		Con el formato de XDY. Donde X es el número de dados e Y las caras de esos dados. ej: 3D20
	[-] onlyMaster	Indica si es una tirada secreta que solo muestra los resultados al master. Los otros jugadores
					son notificados con un mensaje, pero no pueden ver los resultados. Default FALSE
	[-] sort		Indica si se ordenan los resultados sacados de menor a mayor. Default FALSE

