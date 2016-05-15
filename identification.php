<?php
function identification(){ // Identification de l'utlisateur avec protection de l'inculsion
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
			$nickname =htmlentities($_POST["nickname"]);
			$nickname = mysqli_real_escape_string($connexion, $nickname);
      $req= " SELECT *
              FROM users
              WHERE pseudo='$nickname'";
      if (!$resultat = mysqli_query($connexion,$req)){
         return "Identifiant ou mot de passe incorrect<br/>";
      }
	  else{
	  	$ligne=mysqli_fetch_assoc($resultat);
		$a=$_POST["mdp"];
		$pass=md5($a);
      if ($ligne["mdp"]==$pass){
		$_SESSION["nom"]=$ligne['nom'];
		$_SESSION["prenom"]=$ligne['prenom'];
		$_SESSION["mail"]=$ligne['mail'];
		$_SESSION["pseudo"]=$ligne['pseudo'];
		$_SESSION["rank"]=$ligne['rank'];
         header("Location: index.php");
      } else {
         return "Identifiant ou mot de passe incorrect<br/>";
      }        
      }
}
?>
    
