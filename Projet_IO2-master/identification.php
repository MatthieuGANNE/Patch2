<?php
function identification(){
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
      $req= " SELECT *
              FROM users
              WHERE pseudo='$_POST[nickname]'";
      if (!$resultat = mysqli_query($connexion,$req)){
         return "Identifiant ou mot de passe incorrect";
      }
	  $ligne=mysqli_fetch_assoc($resultat);
/* ----------------VOIR POUR LE HASHAGE --------------------------------------*/
		$a=$_POST["mdp"];
		$pass=md5($a);
      if ($ligne["mdp"]==$pass){
		$_SESSION["inscrit"]= true;
		$_SESSION["nom"]=$ligne['nom'];
		$_SESSION["prenom"]=$ligne['prenom'];
		$_SESSION["mail"]=$ligne['mail'];
		$_SESSION["pseudo"]=$ligne['pseudo'];
         header("Location: index.php");
      } else {
         return "Identifiant ou mot de passe incorrect";
      }        
/* ----------------VOIR POUR LE HASHAGE --------------------------------------*/

}
?>
    
