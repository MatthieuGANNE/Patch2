<?php
function preferences(){	
	return " Couleur de fond:<br/>
		<form method=\"post\" action = \"index.php?page=sauvegarde_style\" >
		<SELECT name=\"couleur_fond\" size=\"1\">
			<OPTION>Blanc 
			<OPTION>Noir
			<OPTION>Vert
			<OPTION>Rose
			<OPTION>Violet
			<OPTION>Rouge
		</SELECT>
		<br/>
	Couleur de texte:<br/>
		<SELECT name=\"couleur_texte\" size=\"1\">
			<OPTION>Blanc
			<OPTION>Noir
			<OPTION>Vert
			<OPTION>Rose
			<OPTION>Violet
			<OPTION>Rouge
		</SELECT>
		<br/>
		<input type=\"submit\" value=\"Envoyer\">
		</form>
	
";
}
	
?>	
