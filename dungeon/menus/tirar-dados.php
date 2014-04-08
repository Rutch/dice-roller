<?php
	//TEMPLATE FOR CONTENT CREATION
?>

<div class="content-tirar-dados">
	<h2>TIRAR DADOS</h2>

	<form>
		<fieldset>
			<legend>DICE ROLLER</legend>
			<div>
				<div class="content-tirar-dados-form-element">
					<fieldset>
						<legend>Dado</legend>
						<input style="width: 40px;" type="number" value="1"/> D <input style="width: 40px;" type="number" value="20"/>
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
						<textarea style="width:250px; height:75px" type="text" placeholder="Introduce aquí los emails a quien quieres enviar la tirada, separados por comas. En caso de dejarlo en blanco se enviará a todos."></textarea>
					</fieldset>
				</div>
			<div>
			<div>
				<div class="content-tirar-dados-form-element" style="clear: left;">
					<fieldset>
						<legend>Tirar dados!</legend>
						<button>Tirar dados</button>
						<button>Generar URL</button>
						<input style="width: 626px;" type="text" readonly="readonly"/>
					</fieldset>
				</div>
			<div>
		</fieldset>
	</form>

	<br><br>

	<form>
		<fieldset>
			<legend>INICIATIVA</legend>
			<div>players</div>
			<div>enemies</div>
			<div>onlyMaster=true|false</div>
			<div>debug</div>
			<div>dice</div>
			<div>generar URL | TIRAR DADO</div>
		</fieldset>
	</form>
</div>