###########################################
#	DICE ROLLER - DAIGEONS & DAIGONS
###########################################

[+] Debe existir un archivo 'emails.conf' que debe contener los emails a los que se van a notificar las tiradas,
con una dirección de email por línea, dónde la primera línea debe contener el email del master de la partida. Para crearlo, duplicar y renombrar
'example-emails.conf' editando su contenido.

[+] El servicio diceRoller.php acepta por GET los params siguientes:
	[-] player		Nombre del jugador que hace la tirada (se usará este nombre en el asunto del mail de notificación). Campo OBLIGATORIO.
	[-] dice 		Con el formato de XDY. Donde X es el número de dados e Y las caras de esos dados. ej: 3D20. Default '1D20'
	[-] onlyMaster	Indica si es una tirada secreta que solo muestra los resultados al master. Los otros jugadores
					son notificados con un mensaje, pero no pueden ver los resultados. Default FALSE
	[-] sort		Indica si se ordenan los resultados sacados de menor a mayor. Default FALSE
	[-] debug		Permite entrar un listado de emails separados por comas. Si se usa este parámetro se notificará por email solamente a 
					los indicados en esta lista. El formato de los mails pasados por este param será: 
					debug=Example1<example1@example.com>,Example2<example2@example.com>

