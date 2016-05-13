<?php
function accueil(){
	if (!isset($_SESSION["nom"])){ // Si le champ nom est set, alors ils le sont tous et l'utilisateur est connecté
		return "Veuillez vous identifier pour publier un article <a href=\"index.php?page=connexion\">Connexion</a> <a href=\"index.php?page=inscription\">Inscription</a>";
	} else {
		return accueil_logged($_SESSION["nom"], $_SESSION["prenom"]);
	}
}
function accueil_logged($nom, $prenom){
	return "Bien le bonjour $prenom $nom  ";	
}
        ?>
    
