<script type="text/javascript">
	<?php
		echo "var name = '".$first."';";
	?>
	//DICE-ROLLER
	function generateDiceRollerUrl()
	{
		var dice = "&dice=";
		dice += $("#diceRoller-dice-X").val()+"D"+$("#diceRoller-dice-Y").val();
		var onlyMaster = ($("input[name='onlyMaster'][value='true']").is(':checked'))? "&onlyMaster=true" :"";
		var sort = ($("input[name='sort'][value='true']").is(':checked'))? "&sort=true" :"";
		var debug = "";
		if($("#diceRoller-txt-debug").val() != "")
		{
			var debugArray = $("#diceRoller-txt-debug").val().split(",");
			var emailsArr = [];
			debug = "&debug=";
			for(var email in debugArray)
			{
				emailsArr.push("a<"+debugArray[email]+">");
			}
			debug += emailsArr.join(",");
		}
		return "http://www.tupajar.com/diceRoller/diceRoller.php?player="+name+dice+onlyMaster+sort+debug;
	}
	function onClickGenerateDiceRollerUrl()
	{
		$("#diceRoller-txt-generate").val(generateDiceRollerUrl());
	}
	function onClickDiceRollerTirarDados()
	{
		window.open(generateDiceRollerUrl(), "DAIgeons & DAIgons - Dice-Roller", "width=300, height=200");
	}
	//INICIATIVA
	var currentJugadores = [1,2];
	var currentEnemigos = [1,2];
	function onClickAddJugador()
	{
		var incrementedJugadores = currentJugadores[currentJugadores.length-1] + 1;
		$('<div style="clear: left;" id="iniciativa-jugador-'+incrementedJugadores+'"><input id="iniciativa-jugador-'+incrementedJugadores+'-txt" type="text" placeholder="Nombre jugador"/><button onClick="onClickAddJugador()" type="button" style="background-color:#32CD32; width:22px; margin-left: 3px;">+</button><button onClick="onClickDelJugador('+incrementedJugadores+')" id="iniciativa-jugador-'+incrementedJugadores+'-del" type="button" style="background-color:#ff6347; width:22px; margin-left: 3px;">-</button></div>').insertAfter("#iniciativa-jugador-"+currentJugadores[currentJugadores.length-1]);
		currentJugadores.push(incrementedJugadores);
	}
	function onClickDelJugador(elementId)
	{
		$("#iniciativa-jugador-"+elementId).remove();
		currentJugadores.splice(currentJugadores.indexOf(elementId), 1);
	}
	function onClickAddEnemigo()
	{
		var incrementedEnemigos = currentEnemigos[currentEnemigos.length-1] + 1;
		$('<div style="clear: left;" id="iniciativa-enemigo-'+incrementedEnemigos+'"><input id="iniciativa-enemigo-'+incrementedEnemigos+'-txt" type="text" placeholder="Nombre enemigo"/><button onClick="onClickAddEnemigo()" type="button" style="background-color:#32CD32; width:22px; margin-left: 3px;">+</button><button onClick="onClickDelEnemigo('+incrementedEnemigos+')" id="iniciativa-enemigo-'+incrementedEnemigos+'-del" type="button" style="background-color:#ff6347; width:22px; margin-left: 3px;">-</button></div>').insertAfter("#iniciativa-enemigo-"+currentEnemigos[currentEnemigos.length-1]);
		currentEnemigos.push(incrementedEnemigos);
	}
	function onClickDelEnemigo(elementId)
	{
		$("#iniciativa-enemigo-"+elementId).remove();
		currentEnemigos.splice(currentEnemigos.indexOf(elementId), 1);
	}

	function generateIniciativaUrl()
	{
		var dice = "&dice=";
		dice += $("#iniciativa-dice-X").val()+"D"+$("#iniciativa-dice-Y").val();
		var onlyMaster = ($("input[name='iniciativa-onlyMaster'][value='true']").is(':checked'))? "&onlyMaster=true" :"";
		var players = "";
		var playersArr = [];
		for(var i in currentJugadores)
		{
			if($('#iniciativa-jugador-'+currentJugadores[i]+'-txt').val() != "")
				playersArr.push($('#iniciativa-jugador-'+currentJugadores[i]+'-txt').val());
		}
		if(playersArr.length != 0)
			players = "&players="+playersArr.join(",");
		var enemies = "";
		var enemiesArr = [];
		for(var i in currentEnemigos)
		{
			if($('#iniciativa-enemigo-'+currentEnemigos[i]+'-txt').val() != "")
				enemiesArr.push($('#iniciativa-enemigo-'+currentEnemigos[i]+'-txt').val());
		}
		if(enemiesArr.length != 0)
			enemies = "&enemies="+enemiesArr.join(",");
		var debug = "";
		if($("#iniciativa-txt-debug").val() != "")
		{
			var debugArray = $("#iniciativa-txt-debug").val().split(",");
			var emailsArr = [];
			debug = "&debug=";
			for(var email in debugArray)
			{
				emailsArr.push("a<"+debugArray[email]+">");
			}
			debug += emailsArr.join(",");
		}
		return "http://www.tupajar.com/diceRoller/iniciativa.php?player="+name+dice+onlyMaster+players+enemies+debug;
	}
	function onClickGenerateIniciativaUrl()
	{
		$("#iniciativa-txt-generate").val(generateIniciativaUrl());
	}
	function onClickIniciativaTirarDados()
	{
		window.open(generateIniciativaUrl(), "DAIgeons & DAIgons - Iniciativa", "width=300, height=200");
	}
</script>

<div class="content-tirar-dados">
	<h2>TIRAR DADOS</h2>

	<form>
		<fieldset>
			<legend>DICE ROLLER</legend>
			<div>
				<div class="content-tirar-dados-form-element">
					<fieldset>
						<legend>Dado</legend>
						<input id="diceRoller-dice-X" style="width: 40px;" type="number" value="1" min="1"/> D <input id="diceRoller-dice-Y" style="width: 40px;" type="number" value="20" min="1"/>
					</fieldset>
				</div>
				<div class="content-tirar-dados-form-element">
					<fieldset>
						<legend>Tirada Secreta</legend>
						<input type="radio" name="onlyMaster" value="false" checked="checked"/>Pública
						<input type="radio" name="onlyMaster" value="true"/>Sólo para el master
					</fieldset>
				</div>
				<div class="content-tirar-dados-form-element">
					<fieldset>
						<legend>Ordenar resultados</legend>
						<input type="radio" name="sort" value="false"  checked="checked"/>No
						<input type="radio" name="sort" value="true"/>Sí
					</fieldset>
				</div>
				<div class="content-tirar-dados-form-element">
					<fieldset>
						<legend>Debug</legend>
						<textarea id="diceRoller-txt-debug" style="width:250px; height:75px; resize: none;" type="text" placeholder="Introduce aquí los emails a quien quieres enviar la tirada, separados por comas. En caso de dejarlo en blanco se enviará a todos."></textarea>
					</fieldset>
				</div>
			</div>
			<div>
				<div class="content-tirar-dados-form-element" style="clear: left;">
					<fieldset>
						<legend>Tirar dados!</legend>
						<button onClick="onClickDiceRollerTirarDados()" type="button" >Tirar dados</button>
						<button onClick="onClickGenerateDiceRollerUrl()" type="button" id="diceRoller-btn-generate">Generar URL</button>
						<input id="diceRoller-txt-generate" style="width: 626px;" type="text" readonly="readonly"/>
					</fieldset>
				</div>
			</div>
		</fieldset>
	</form>

	<br><br>

	<form>
		<fieldset>
			<legend>INICIATIVA</legend>
			<div>
				<div class="content-tirar-dados-form-element">
					<fieldset>
						<legend>Dado</legend>
						<input id="iniciativa-dice-X" style="width: 40px;" type="number" value="1" min="1" readonly="readonly"/> D <input id="iniciativa-dice-Y" style="width: 40px;" type="number" value="10" min="1"/>
					</fieldset>
				</div>
			</div>
			<div class="content-tirar-dados-form-element">
				<fieldset>
					<legend>Tirada Secreta</legend>
					<input type="radio" name="iniciativa-onlyMaster" value="false" checked="checked"/>Pública
					<input type="radio" name="iniciativa-onlyMaster" value="true"/>Sólo para el master
				</fieldset>
			</div>
			<div class="content-tirar-dados-form-element">
				<fieldset>
					<legend>Jugadores</legend>
					<div style="clear: left;" id="iniciativa-jugador-1"><input id="iniciativa-jugador-1-txt" type="text" placeholder="Nombre jugador"/><button onClick="onClickAddJugador()" type="button" style="background-color:#32CD32; width:22px; margin-left: 3px;">+</button></div>
					<div style="clear: left;" id="iniciativa-jugador-2"><input id="iniciativa-jugador-2-txt" type="text" placeholder="Nombre jugador"/><button onClick="onClickAddJugador()" type="button" style="background-color:#32CD32; width:22px; margin-left: 3px;">+</button><button onClick="onClickDelJugador(2)" id="iniciativa-jugador-2-del" type="button" style="background-color:#ff6347; width:22px; margin-left: 3px;">-</button></div>
				</fieldset>
			</div>
			<div class="content-tirar-dados-form-element">
				<fieldset>
					<legend>Enemigos</legend>
					<div style="clear: left;" id="iniciativa-enemigo-1"><input id="iniciativa-enemigo-1-txt" type="text" placeholder="Nombre enemigo"/><button onClick="onClickAddEnemigo()" type="button" style="background-color:#32CD32; width:22px; margin-left: 3px;">+</button></div>
					<div style="clear: left;" id="iniciativa-enemigo-2"><input id="iniciativa-enemigo-2-txt" type="text" placeholder="Nombre enemigo"/><button onClick="onClickAddEnemigo()" type="button" style="background-color:#32CD32; width:22px; margin-left: 3px;">+</button><button onClick="onClickDelEnemigo(2)" id="iniciativa-enemigo-2-del" type="button" style="background-color:#ff6347; width:22px; margin-left: 3px;">-</button></div>
				</fieldset>
			</div>
			<div class="content-tirar-dados-form-element">
				<fieldset>
					<legend>Debug</legend>
					<textarea id="iniciativa-txt-debug" style="width:250px; height:75px; resize: none;" type="text" placeholder="Introduce aquí los emails a quien quieres enviar la tirada, separados por comas. En caso de dejarlo en blanco se enviará a todos."></textarea>
				</fieldset>
			</div>
			<div>
				<div class="content-tirar-dados-form-element" style="clear: left;">
					<fieldset>
						<legend>Tirar dados!</legend>
						<button onClick="onClickIniciativaTirarDados()" type="button" >Tirar dados</button>
						<button onClick="onClickGenerateIniciativaUrl()" type="button" id="iniciativa-btn-generate">Generar URL</button>
						<input id="iniciativa-txt-generate" style="width: 626px;" type="text" readonly="readonly"/>
					</fieldset>
				</div>
			</div>
		</fieldset>
	</form>
</div>

<script type="text/javascript">
	//Auto-selecting url on dice-roller
	$("#diceRoller-txt-generate").click(function() { $(this).select() });
</script>