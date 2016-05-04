<?php 
function sauvegarde(){	

         $remplis=true;
         $valide=true;

         if (!(isset($_POST["nom"]))|| $_POST["nom"]=="")
			$remplis=false;
         if (!(isset($_POST["prenom"]))|| $_POST["prenom"]=="")
			$remplis=false;
         //if (!(isset($_POST["date"])) || $_POST["date"]=="")
         //$remplis=false;
         if (!(isset($_POST["mail"])) || $_POST["mail"]=="")
			$remplis=false;
         if ($_POST["nom"]!=htmlspecialchars($_POST["nom"]) )
			$valide=false;
         if ($_POST["prenom"]!=htmlspecialchars($_POST["prenom"]))
			$valide=false;
         //if ($_POST["date"]!=htmlentities($_POST["date"]))
         //$valide=false;
	 
         if ($_POST["mail"]!=htmlspecialchars($_POST["mail"]))
         $valide=false;
	


         if (!$remplis){
         return "remplis mieux <br/> <a href=\"index.php?page=inscription\">Retourner au form</a>";
         } else if(!$valide){
         return "c'est pas valide <br/> <a href=\"index.php?page=inscription\">Retourner au form</a>";
      } else {
   

			$server= "localhost";
			$user="root";
			$base="blog";
			$password="";
			$connexion = mysqli_connect($server, $user, $password);//  mysqli_connec() pb de compilation?
			if(!$connexion) {
				echo "connexion none"; exit;
			}
			if (!mysqli_select_db($connexion,$base)){
				echo "pas de base"; exit;
			}
			if(!isset($_SESSION["nom"])){
				$_SESSION["rank"]=0;
				echo"c<br/>";
				$pass=md5("$_POST[mdp1]");
				$req="INSERT INTO users (nom, prenom, pseudo, mail,mdp) VALUES('$_POST[nom]','$_POST[prenom]','$_POST[pseudo]','$_POST[mail]','$pass')";
				mysqli_query($connexion,$req) OR die(mysqli_sqlstate($connexion));
			} else {
				$req="UPDATE users 
				SET nom = '$_POST[nom]', 
				prenom = '$_POST[prenom]', 
				pseudo='$_POST[pseudo]', 
				mail='$_POST[mail]' 
				WHERE mail='$_SESSION[mail]'";
				mysqli_query($connexion,$req) OR die(mysqli_sqlstate($connexion));
			}		
			$_SESSION["nom"]=$_POST["nom"];
			$_SESSION["prenom"]= $_POST["prenom"];
			$_SESSION["pseudo"] = $_POST["pseudo"];
			//$_SESSION["date"]=$_POST["date"];
			$_SESSION["mail"]= $_POST["mail"];
			$_SESSION["inscrit"]= true;	
			header("location:index.php");
		}
}
?>
