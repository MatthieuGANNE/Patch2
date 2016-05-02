<?php
function acceuil(){
	if (!isset($_SESSION["nom"])){
		return "Veuillez vous identifier pour publier un article";
	} else {
		return acceuil_logged($_SESSION["nom"], $_SESSION["prenom"]);
	}
}
function acceuil_logged($nom, $prenom){
	return "Bien le bonjour $prenom $nom <br/> 
	<a href=\"index.php?page=article_form\">Publier un article</a>";	
}
        ?>
    
