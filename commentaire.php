<?php
function sauvegarde_commentaire(){ // Fontion interne qui enregistre les commentaires dans la base de donnée en protégeant contre les inclusions
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
		$reqid= "SELECT id
              FROM users
              WHERE mail ='$_SESSION[mail]'";
		$resultatid = mysqli_query($connexion, $reqid);
	    $ligne = mysqli_fetch_assoc($resultatid);
		$id_users = $ligne['id'];
		$id_article = $_POST['id'];
		$contenu=mysqli_real_escape_string($connexion,$_POST["contenu"]);
		$contenu=htmlentities($contenu);
		$date = date("Y-m-d");
		header('Location: index.php?page=consulter&id='.$id_article);
		$req="INSERT INTO commentaire (date, id_users, id_article, contenu)
	VALUES ('$date', '$id_users', '$id_article', '$contenu')";
	mysqli_query($connexion, $req) OR die(mysqli_sqlstate($connexion));
	echo "Publication réussie";
	header('Location: index.php?page=consulter&id='.$id_article);		
}
?>
