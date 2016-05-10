<!DOCTYPE html>
<?php session_start(); ?>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="default.css" />
    <?php if (isset($_SESSION["style"])) echo "<link rel=\"stylesheet\" href=$_SESSION[style].css />";
          ?>
    <title>Index</title>
  </head>
  <body>
  <span id=haut_de_page></span>
    <?php
       include "permanent.php";
       include "inscription.php";
       include "sauvegarde.php";
       include "accueil.php";
       include "connexion.php";
       include "article.php";
       include "identification.php";
	   include "commentaire.php";
	   include "moderation.php";
       ?>
    <header>
      <?php
         echo afficher_header();
		 
         ?>
    </header>
	
    <?php
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
       if (!isset($_GET["page"])){
			echo accueil_article();
       } else {
       if ($_GET["page"]=="inscription" || $_GET["page"]=="modifier")
          echo inscription();
       if ($_GET["page"]=="sauvegarde")
          echo sauvegarde();
       if ($_GET["page"]=="preferences")
          echo preferences();
       if ($_GET["page"]=="deconnexion"){      
           session_unset(); // Cette fonction marche alors que unset($_SESSION) marchait pas
           header("Location: index.php");
       }
       if ($_GET["page"]=="connexion")
           echo connexion();
       
          
		if($_GET["page"]=="article_form"){
				article_form();
			echo"<br>";
		}	
		if($_GET["page"]=="sauvegarde_article")
				article_sauvegarde();
			
		if($_GET["page"]=="consulter"){
			echo afficher_article($_GET["id"]);
			article_commentaire($_GET["id"]);
		}	
		
		if($_GET["page"] == "sauvegarde_commentaire"){
			sauvegarde_commentaire();
		}
		
	   if ($_GET["page"]=="identification"){
          echo identification();
       }
	    if ($_GET["page"]=="ancien_article"){
          echo afficher_titre_article();
       }         
	   if ($_GET["page"]=="mes_articles"){
		   echo afficher_titre_utilisateur($_SESSION['mail']);
	   }
	   if ($_GET["page"]=="modifier_page"){
		    $req= "SELECT pseudo
					FROM users
					WHERE id = (SELECT id_users FROM article WHERE id=$_GET[id])";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
		if ($_SESSION["pseudo"]==$ligne["pseudo"] || $_SESSION["rank"]==1){
			article_modification($_GET['id']);
		} else {
			echo redirection();
		}
	   }
	   if ($_GET["page"]=="modifier_article"){
		   $req= "SELECT pseudo
					FROM users
					WHERE id = (SELECT id_users FROM article WHERE id=$_GET[id])";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
		if ($_SESSION["pseudo"]==$ligne["pseudo"] || $_SESSION["rank"]==1){
		   echo sauvegarde_modification_article($_GET['id']);
		} else {
			echo redirection();
		}
	   }
	   if ($_GET["page"]=="supprimer_article"){
		   $req= "SELECT pseudo
					FROM users
					WHERE id = (SELECT id_users FROM article WHERE id=$_GET[id])";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
		if ($_SESSION["pseudo"]==$ligne["pseudo"] || $_SESSION["rank"]==1){
		   echo supprimer_article();
		} else {
			echo redirection();
		}
	   }
	   if ($_GET["page"]=="moderation_utilisateur"){
		   if (isset($_SESSION["rank"]) && $_SESSION["rank"]==1){
		   echo page_moderation();
		   }else {
				echo redirection();
			}
	   }
	   if ($_GET["page"]=="article_utilisateur"){
		   $req= "SELECT mail
				  FROM users
					WHERE id=$_GET[id]";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
		   echo afficher_titre_utilisateur($ligne['mail']);
	   }	
	   if ($_GET["page"]=="supprimer_utilisateur"){
		   if (isset($_SESSION["rank"]) && $_SESSION["rank"]==1){
		   echo supprimer_utilisateur();
		   }else {
				echo redirection();
			}
	   }
	   if ($_GET["page"]=="moderation_categorie"){
		   if (isset($_SESSION["rank"]) && $_SESSION["rank"]==1){
		   echo moderation_categorie();
		   }else {
				echo redirection();
			}
	   }
	   if ($_GET["page"]=="supprimer_categorie"){
		    if (isset($_SESSION["rank"]) && $_SESSION["rank"]==1){
				echo supprimer_categorie();
			}else {
				echo redirection();
			}
	   }
	   
	   if ($_GET["page"]=="supprimer_commentaire"){
		     $req= "SELECT *
					FROM users AS u, article AS a, commentaire AS c
					WHERE c.id=$_GET[id]
					AND a.id=c.id_article
					AND u.id=a.id_users";
		$resultat = mysqli_query($connexion, $req);
		$ligne = mysqli_fetch_assoc($resultat);
		$req1="SELECT pseudo, id_users
				FROM users, commentaire
				WHERE commentaire.id=$_GET[id]
				AND users.id=id_users";
		$resultat1 = mysqli_query($connexion, $req1);
		$ligne1 = mysqli_fetch_assoc($resultat1);
		if ($_SESSION["pseudo"]==$ligne["pseudo"] || $_SESSION["pseudo"]==$ligne1["pseudo"] || $_SESSION["rank"]==1){
		   echo supprimer_commentaire($_GET['id']);
		} else {
			echo redirection();
		}
	   }
	   }
		echo "<br>";	
	   
       ?>
	   <footer>
	<?php
	echo afficher_footer();
         ?>
</footer>
	   <br/>
	   <div class=fixe> <a href=index.php> Retourner à l'accueil </a> 
	   <a href=#haut_de_page>Haut de page </a></div>
       </body>
	   
</html>
