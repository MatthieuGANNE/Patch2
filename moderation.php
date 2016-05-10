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
		echo $ligne['pseudo'] . " <a href=\"index.php?page=article_utilisateur&id=" .$ligne['id'] ."\">Accéder aux articles</a> <a href=\"index.php?page=supprimer_utilisateur&id=" . $ligne['id'] . "\">Supprimer l'utilisateur</a>";
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

function moderation_categorie(){
	echo "<form action=\"index.php?page=moderation_categorie\" method=\"post\">
			Ajoutez une nouvelle catégorie<input type=\"text\" name=\"nouvelle_categorie\"</input>
			<input type=\"submit\" value=\"Envoi\"</input>
			</form>";
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
	if (isset($_POST["nouvelle_categorie"])){
		$req="INSERT INTO categorie (nom) VALUES ('$_POST[nouvelle_categorie]')";
		mysqli_query($connexion,$req);
		echo "$_POST[nouvelle_categorie] a bien été ajouté à la liste des catégories<br>";
	}
	$req="SELECT *
		  FROM categorie
		  WHERE 1";
		$resultat=mysqli_query($connexion, $req);
		$ligne=mysqli_fetch_assoc($resultat);
		while($ligne){
			echo"$ligne[nom] <a href=\"index.php?page=supprimer_categorie&id=$ligne[id]\">Supprimer cet gatégorie</a><br>";
			$ligne=mysqli_fetch_assoc($resultat);
		}	
}

function supprimer_categorie(){
	
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
	$req="UPDATE article
			SET id_categorie = -1
			WHERE id_categorie = $_GET[id]";
	mysqli_query($connexion, $req);
	$req="DELETE FROM categorie
	WHERE id=$_GET[id]";
	mysqli_query($connexion,$req);
	
}

function redirection(){
	return "<h1>Oops</h1>Vous n'avez pas l'autorisation pour accéder à cette page";
}

function supprimer_commentaire(){
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
	$req="SELECT id_article 
		FROM commentaire
		WHERE id=$_GET[id]";
	$resultat=mysqli_query($connexion,$req);
	$ligne=mysqli_fetch_assoc($resultat);
	$req="DELETE FROM commentaire
		  WHERE id=$_GET[id]";
	mysqli_query($connexion, $req);
	header('Location: index.php?page=consulter&id='.$ligne[id_article]);

	
}
?>