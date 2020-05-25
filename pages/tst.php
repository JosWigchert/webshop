<!DOCTYPE html>
<html>
<head>
	<title>Formulier</title>
	<style>
		label {display:block;}
		:invalid {background: #ffdddd;}
	</style>
</head>

<body>
	<form>
		<fieldset>
		
			<legend>Contactgegevens</legend>
		
			<label for="name">Naam *</label>
			<input type="text" id="name" required>

			<label for="email">Email *</label>
			<input type="email" id="email" required>

			<label for="straat">Straatnaam</label>
			<input type="text" id="straat" placeholder="Zonder huis nummer">

			<label for="nummer">Huis nummer</label>
			<input type="number" id="nummer">

			<label for="postcode">Postcode</label>
			<input type="number" class="postcode" pattern="[0-9]{4}" placeholder="4 nummers"/> 
			<input type="text" class="postcode" pattern="[A-Z]{2}" placeholder="2 letters"/>

			<label for="land">Land</label>
			<input type="text" id="land">
		
			<label for="telefoon">Telefoon</label>
			<input type="tel" id="telefoon">
		
		</fieldset>

		<fieldset>
	
			<legend>Voorkeuren</legend>
		
			<label for="kleur">Lievelings kleur</label>
			<input type="color" id="kleur">
		
			<label for="maand">Leukste maand</label>
			<select id="maand">
				<option>januari</option>
				<option>februari</option>
				<option>maart</option>
				<option>april</option>
				<option>mei</option>
				<option>juni</option>
				<option>juli</option>
				<option>augustus</option>
				<option>september</option>
				<option>oktober</option>
				<option>november</option>
				<option>december"</option>
			</select>
		
			<label for="cijfer">Hoe goed is dit ongeveer?</label>
			<select id="maand">
				<option>1</option>
				<option>2</option>
				<option>3</option>
				<option>4</option>
				<option>5</option>
				<option>6</option>
				<option>7</option>
				<option>8</option>
				<option>9</option>
				<option>10</option>
			</select>
		</fieldset>
		<input type="submit" value="Submit" />
		
	</form>
</body>
</html>