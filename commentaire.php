<?php
function sauvegarde_commentaire(){
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
		$date = date("Y-m-d");
		$req="INSERT INTO commentaire (date, id_users, id_article, contenu)
	VALUES ('$date', '$id_users', '$id_article', '$_POST[contenu]')";
	echo $req;
	mysqli_query($connexion, $req) OR die(mysqli_sqlstate($connexion));
	echo "Publication réussie";
	header('Location: index.php?page=consulter&id='.$id_article);		
}
?>