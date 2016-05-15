<?php


function afficher_article($n){ // Affiche l'article
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
	$req2="SELECT nom
	        FROM categorie
			WHERE id=$ligne[id_categorie]";
	$resultat2 = mysqli_query($connexion,$req2);
	$ligne2 = mysqli_fetch_assoc($resultat2);
	if(!isset($_SESSION["mail"])){   // Affiche l'article sans possibilité de modification si l'utilisateru n'est pas connecté
      return "<div id=\"article\">
              <h1>$ligne[nom] $ligne2[nom]</h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div><br>";
	}
	if ($_SESSION["rank"]==1 || $ligne1["pseudo"]==$_SESSION["pseudo"]){ // Affiche l'article dans ub formulaire si l'utilasateur est un administrateur ou si l'utisateur est l'auteur de l'article
		return "<div id=\"article_entier\">
              <h1>$ligne[nom] <span id=genre>$ligne2[nom]</span><a href=\"index.php?page=modifier_page&id=$n\">Modifier</a> <a href=\"index.php?page=supprimer_article&id=$n\">Supprimer</a><br/></h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div>  
			  Commentaire: <br> <textarea rows=\"4\" cols=\"40\" name=\"contenu\"  placeholder=\"Commentaire\"></textarea> 
			  <form action=\"index.php?page=sauvegarde_commentaire\" method=\"post\" id=\"comentaire\">
			  <input type=\"hidden\" name=\"id\" value=$_GET[id]>
			  <input type=\"submit\" value=\"Envoyer\"><br/>
			  </form><br>"; // Formulaire d'écriture de commentaire pour l'article
	} // Sinon  Envoyer l'article non modifiable avec la possibilité de poster un commentaire
		return "<div id=\"article\">
              <h1>$ligne[nom] <span id=genre>$ligne2[nom]</span></h1>
              <h2>$ligne1[nom] $ligne1[prenom] $ligne1[pseudo]</h2>
              <h3>$ligne[date]</h3>
              <p>$ligne[contenu]</p>
              </div>  
			  Commentaire: <br> <textarea rows=\"4\" cols=\"40\" name=\"contenu\" form=\"comentaire\" placeholder=\"Commentaire\"></textarea>
			  <form action=\"index.php?page=sauvegarde_commentaire\" method=\"post\" id=\"comentaire\">
			  <input type=\"hidden\" name=\"id\" value=$_GET[id]>
			  <input type=\"submit\" value=\"Envoyer\"><br/>
			  </form><br>";
		
	
}
function article_form(){ // Formulaire d'écriture d'un article avec le choix d'une catégorie
 	  echo "<form action=\"index.php?page=sauvegarde_article\" method=\"post\" id=\"article\">
                  Titre:<input type=\"text\" name=\"titre\"><br/>
				 Genre:	<SELECT name=\"genre\" size=\"1\">" ;
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
        FROM categorie
        WHERE 1";
	$resultat = mysqli_query($connexion,$req);
	$ligne = mysqli_fetch_assoc($resultat);
				 while($ligne){
					echo "<option value=\"$ligne[id]\">$ligne[nom]</option>";	
					$ligne = mysqli_fetch_assoc($resultat);					 
				 }
				 echo "</SELECT>";
                 echo "<input type=\"submit\" value=\"Envoyer\"><br/>
           </form>
 		   Contenu : <br> <textarea rows=\"25\" cols=\"75\" name=\"contenu\" form=\"article\" placeholder=\"Article\"></textarea>";
}
function article_sauvegarde(){ // dontion interne qui sauvegarde l'article dans la base de donnée et protège les données envoyée puis renvoie à la page d'accueil
	
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
		 $contenu=mysqli_real_escape_string($connexion,$_POST['contenu']);
		 $titre=mysqli_real_escape_string($connexion,$_POST['titre']);
		 $contenu=htmlentities($contenu);
		 $titre=htmlentities($titre);
		 $genre=mysqli_real_escape_string($connexion,$_POST['genre']);
		 echo '$contenu';
	$date = date("Y-m-d");
			$req="INSERT INTO article (nom, date, id_users, contenu, id_categorie)
 VALUES ('$titre', '$date', '$ligne[id]', '$contenu', '$genre')";
	mysqli_query($connexion, $req) OR die(mysqli_sqlstate($connexion));
	echo "Publication réussie";
	header('Location: index.php');
 }
function article_commentaire($n){ //Affiche les commentaires 
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
        WHERE id_article=$n";
		$result="";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
		while($ligne){
			$req= "SELECT pseudo
        FROM users
        WHERE id='$ligne[id_users]'";
		$resultat1 = mysqli_query($connexion, $req);
	    $ligne1 = mysqli_fetch_assoc($resultat1);
		$req="SELECT pseudo
				FROM users 
				WHERE id= (SELECT id_users
				FROM article
				WHERE id=$n)";
				$resultat2=mysqli_query($connexion,$req);
				$ligne2=mysqli_fetch_assoc($resultat2);
		$nom = $ligne1['pseudo'];		
		if ($nom==""){
			$nom="<em>Banni</em>";
		}
		if (!(isset($_SESSION["mail"])) || (!($_SESSION["rank"]==1 || $ligne1["pseudo"]==$_SESSION["pseudo"] || $ligne2["pseudo"]==$_SESSION["pseudo"]))){
			echo $nom . " ".  $ligne['date'] ."<br/>". $ligne['contenu'] ."<br/>";
		} else {
			echo $nom . " ".  $ligne['date'] . " <a href=\"index.php?page=supprimer_commentaire&id=$ligne[id]\">Supprimer</a><br>"  . $ligne['contenu'] ."<br><br>";
		}
		
		$ligne = mysqli_fetch_assoc($resultat);
		}
}
function article_partiel($n){ // Utilisé pour les articles de la page d'accueil
	
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
	$req2="SELECT nom
	        FROM categorie
			WHERE id=$ligne[id_categorie]";
	$resultat2 = mysqli_query($connexion,$req2);
	$ligne2 = mysqli_fetch_assoc($resultat2);
			
      return "<div id=\"article\">
              <h1><a href=\"index.php?page=consulter&id=$ligne[id]\">$ligne[nom]</a> <span id=genre>$ligne2[nom]</span></h1>
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
        ORDER BY id DESC
		LIMIT 5";
		$resultat = mysqli_query($connexion, $req);
	    $ligne = mysqli_fetch_assoc($resultat);
		echo "<div id=\"accueil_article\"><br>";
		while($ligne){
		echo article_partiel($ligne['id']);
		$ligne = mysqli_fetch_assoc($resultat);
		}
		echo"</div>";
		 
	
}
function titre_article($n){ //Fonction utilisée dans la fonction qui affiche tout les articles
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
		if ($nom==""){
			$nom="<em>Banni</em>";
		}
		return "<a href =\"index.php?page=consulter&id=$n\" >$titre</a> Auteur: $nom";
}
function afficher_titre_article(){ // Affiche les anciens article et le nom de leur auteur
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
			echo "<form action=\"index.php?page=ancien_article\" method=\"post\">
			Genre:	<SELECT name=\"genre\" size=\"1\">
					<option value=\"-1\">Tous</option>" ; // Possibilité de Trier les articles par genre
			$req= "SELECT *
			FROM categorie
			WHERE 1";
			$resultat = mysqli_query($connexion,$req);
			$ligne = mysqli_fetch_assoc($resultat);
				 while($ligne){
					echo "<option value=\"$ligne[id]\">$ligne[nom]</option>";	
					$ligne = mysqli_fetch_assoc($resultat);					 
				 }
				 echo "</SELECT>";
                 echo "<input type=\"submit\" value=\"Envoyer\"><br/>
           </form>";
					
			if (!isset($_POST["genre"])|| $_POST['genre']==-1){
			$req= "SELECT id
				FROM article
				WHERE 1";
			} else {
				$genre=mysqli_real_escape_string($connexion,$_POST["genre"]);
				$req="SELECT id
				FROM article
				WHERE id_categorie=$genre";
			}
			$resultat = mysqli_query($connexion, $req);
			$ligne = mysqli_fetch_assoc($resultat);
			while($ligne){
			echo titre_article($ligne['id']);
			echo"<br/>";
			$ligne = mysqli_fetch_assoc($resultat);
			}
	}
	
	function afficher_titre_utilisateur($session_mail){ // Affiche les anciens articles de l'utilisateur enregistré
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
				WHERE mail='$session_mail'";
			$resultatid = mysqli_query($connexion, $reqid);
			$ligneid = mysqli_fetch_assoc($resultatid);
			$req= "SELECT id, nom
				FROM article
				WHERE id_users='$ligneid[id]'";
			$resultat = mysqli_query($connexion, $req);
			$ligne = mysqli_fetch_assoc($resultat);
			while($ligne){
			echo "<a href =\"index.php?page=consulter&id=$ligne[id]\" >$ligne[nom]</a>";
			echo"<br/>";
			$ligne = mysqli_fetch_assoc($resultat);
		}
}
function article_modification($n){ // modification d'un article
	  echo "<form action=\"index.php?page=modifier_article&id=$n\" method=\"post\" id=\"article\">";
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
			}	$req= "SELECT *
        FROM article
        WHERE id='$n'";	
		
		$resultat = mysqli_query($connexion,$req);
	    $ligne = mysqli_fetch_assoc($resultat);
		$req1= "SELECT *
        FROM categorie
        WHERE id=$ligne[id_categorie]";	
		
		$resultat1 = mysqli_query($connexion,$req1);
	    $ligne1 = mysqli_fetch_assoc($resultat1);
			echo "Titre:$ligne[nom]
				 Genre:$ligne1[nom]<br>";
                 echo "<input type=\"submit\" value=\"Envoyer\"><br/>
           </form>
		   Contenu : <br> <textarea rows=\"25\" cols=\"75\" name=\"contenu\" form=\"article\">
	$ligne[contenu]</textarea>";
}
function sauvegarde_modification_article() { // Fontion interne qui enregistre la modification d'un article dans la base de données en protégeant des inclusions
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
			$contenu=mysqli_real_escape_string($connexion,$_POST['contenu']);
			$contenu=htmlentities($contenu);
			$req="UPDATE article 
				SET contenu='$contenu'
				WHERE id=$_GET[id]";
	mysqli_query($connexion, $req) OR die(mysqli_sqlstate($connexion));
	
	header('Location: index.php');	
	echo "Publication réussie<br>";
}

function supprimer_article(){ // Suprimme l'article demandé par l'utilisateur
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
			$req= "DELETE FROM article
						WHERE id=$_GET[id]";
			mysqli_query($connexion,$req);
			echo "Cetter article a bien été supprimé<br>";
			echo "<a href=index.php>Retourner à l'accueil</a><br>";
}
						
?>
