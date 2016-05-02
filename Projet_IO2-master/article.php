<?php
function article_entier($n){
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
		$req= "SELECT id
        FROM article
        WHERE 1";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
        $req= "SELECT *
              FROM article
              WHERE id=$n";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
	
	$req1 = "SELECT nom, prenom, pseudo 
			 FROM users
			 WHERE id='$ligne[id_users]'";
	$resultat1 = mysqli_query($connexion,$req1);
	$ligne1 = mysqli_fetch_assoc($resultat1);
      return "<div id=\"article\">
              <h1>$ligne[nom] $ligne[genre]</h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div>";
}

function article_form(){ // Ecriture d'un article
	  echo "<form action=\"index.php?page=sauvegarde_article\" method=\"post\" id=\"article\">
                 Titre:<input type=\"text\" name=\"titre\"><br/>
				 Genre:	<SELECT name=\"genre\" size=\"1\"> 
			<OPTION>International
			<OPTION>Politique
			<OPTION>Economie
			<OPTION>Planète
			<OPTION>Sport
			<OPTION>Sciences
		</SELECT> <br>
                 <input type=\"submit\" value=\"Envoyer\"><br/>
           </form>
		   Contenu : <br> <<textarea rows=\"25\" cols=\"75\" name=\"contenu\" form=\"article\">
Enter text here...</textarea>";
}
function article_sauvegarde(){
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
	$date = date("Y-m-d");
			$req="INSERT INTO article (nom, date, id_users, contenu, genre)
 VALUES ('$_POST[titre]', '$date', '$ligne[id]', '$_POST[contenu]', '$_POST[genre]')";
	mysqli_query($connexion, $req) OR die(mysqli_sqlstate($connexion));
	echo "Publication réussie";
	header('Location: index.php');
 }

function accueil_article(){ // affichage des articles dans la page d'accueil
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
			
		$req= "SELECT id
        FROM article
        WHERE 1";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
		
		while($ligne){
		echo article_entier($ligne['id']);
		$ligne = mysqli_fetch_assoc($resultat);
		}
		 
	
}