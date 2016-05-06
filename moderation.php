<?php

function page_moderation(){
	$server= "localhost";
	$user="root";
	$base="blog";
	$password="";
	$connexion = mysqli_connect($server, $user, $password,$base);
			if (!$connexion){
			echo "connexion none"; exit;
			}
			if (!mysqli_select_db($connexion,$base)){
			echo "pas de base"; exit;
			}
        $req= "SELECT pseudo,id
              FROM users
              WHERE rank=0";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
		while($ligne){
		echo $ligne['pseudo'] . "<a href=\"index.php?page=article_utilisateur&id=" .$ligne['id'] ."\">Accéder aux articles</a> <a href=\"index.php?page=supprimer_utilisateur&id=" . $ligne['id'] . "\">Supprimer l'utilisateur</a>";
		$ligne=mysqli_fetch_assoc($resultat);
		echo"<br>";
		}
}
function supprimer_utilisateur(){
	$server= "localhost";
	$user="root";
	$base="blog";
	$password="";
	$connexion = mysqli_connect($server, $user, $password,$base);
			if (!$connexion){
			echo "connexion none"; exit;
			}
			if (!mysqli_select_db($connexion,$base)){
			echo "pas de base"; exit;
			}
        $req= "DELETE FROM users
              WHERE id = $_GET[id]";
        mysqli_query($connexion, $req);
;		echo "Le profil a bien été supprimé<br>";
}

?>
