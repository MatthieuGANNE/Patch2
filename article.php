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
              <h1><a href=\"index.php?page=consulter&id=$ligne[id]\">$ligne[nom]</a> $ligne[genre]</h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div> <br>";
}

function afficher_article($n){
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
	if(!isset($_SESSION["mail"])){
      return "<div id=\"article\">
              <h1>$ligne[nom] $ligne[genre]</h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div><br>";
	}else {
		return "<div id=\"article\">
              <h1>$ligne[nom] $ligne[genre]</h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div>  
			  Commentaire: <br> <textarea rows=\"15\" cols=\"50\" name=\"contenu\" form=\"comentaire\">
			  ... </textarea>
			  <form action=\"index.php?page=sauvegarde_commentaire\" method=\"post\" id=\"comentaire\">
			  <input type=\"hidden\" name=\"id\" value=$_GET[id]>
			  <input type=\"submit\" value=\"Envoyer\"><br/>
			  </form><br>";
		
	}
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
		   Contenu : <br> <textarea rows=\"25\" cols=\"75\" name=\"contenu\" form=\"article\">
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
function article_commentaire($n){
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
	$req= "SELECT *
        FROM commentaire
        WHERE id_article='$n'";
		$result="";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
		while($ligne){
			$req= "SELECT pseudo
        FROM users
        WHERE id='$ligne[id_users]'";
		$resultat1 = mysqli_query($connexion, $req);
	    $ligne1 = mysqli_fetch_assoc($resultat1);
		echo $ligne1['pseudo'] . " ".  $ligne['date'] . "<br>"  . $ligne['contenu'] ."<br><br>";
		$ligne = mysqli_fetch_assoc($resultat);
		}
}
function article_partiel($n){
	
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
	$contenu=substr($ligne["contenu"],0,200);
      return "<div id=\"article\">
              <h1><a href=\"index.php?page=consulter&id=$ligne[id]\">$ligne[nom]</a> $ligne[genre]</h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$contenu</p>
              </div> <br>";
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
		echo article_partiel($ligne['id']);
		$ligne = mysqli_fetch_assoc($resultat);
		}
		 
	
}
function titre_article($n){
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
			
		$req= "SELECT nom, id_users
        FROM article
        WHERE id=$n";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
		$titre=$ligne["nom"];
		$mp=$ligne["id_users"];
		$req= "SELECT nom
        FROM users
        WHERE id=$mp";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
		$nom=$ligne["nom"];
		return "<a href =\"index.php?page=consulter&id=$n\" >$titre</a> $nom";
}
function afficher_titre_article(){
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
			echo titre_article($ligne['id']);
			echo"<br/>";
			$ligne = mysqli_fetch_assoc($resultat);
		}
}

