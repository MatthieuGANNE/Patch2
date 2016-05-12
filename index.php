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
        include "permanent.php"; // inclusion des bibliothèques de fonctions
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
         echo afficher_header(); // affichage du header sur chaque page 
         ?>
    </header>
	
    <?php
	$server= "localhost";
	$user="root";
	$base="blog";
	$password="";
	$connexion = mysqli_connect($server, $user, $password,$base); // Connection à la base de donnée
	if (!$connexion){
		echo "connexion none"; exit;
	}
	if (!mysqli_select_db($connexion,$base)){
		echo "pas de base"; exit;
	}
	
       if (!isset($_GET["page"])){ // si l'utilisateur n'a pas demandé de page en particulier on affiche la page d'accueil
			echo accueil_article();
       } else {
       	
       if ($_GET["page"]=="inscription" || $_GET["page"]=="modifier") // Demande d'inscription ou de modification de profil
          echo inscription();
       if ($_GET["page"]=="sauvegarde") // Fonction interne qui permet de sauvegarder les changements des informations de l'utilisateur
          echo sauvegarde();
       if ($_GET["page"]=="preferences")
          echo preferences();
       if ($_GET["page"]=="deconnexion"){ // on enlève les cookies qui permettait de facliter la navigation et on redirige l'utilisateur vers l'accueil
           session_unset(); 
           header("Location: index.php");
       }
       if ($_GET["page"]=="connexion") // Page de connexion
           echo connexion();
       
       if($_GET["page"]=="article_form"){ // Page d'édition d'un article
		article_form();
		echo"<br>";
	}	
	
	if($_GET["page"]=="sauvegarde_article")// Fonction interne qui sauvegarde les articles et les changements sur l'article
		article_sauvegarde();
			
	if($_GET["page"]=="consulter"){ // Consultation d'un article en particulier avec ces commentaires
		echo afficher_article($_GET["id"]);
		article_commentaire($_GET["id"]);
	}	
		
	if($_GET["page"] == "sauvegarde_commentaire"){ // Fonction interne qui permet de sauvegarder un nouveau commentaire
		sauvegarde_commentaire();
	}
		
	if ($_GET["page"]=="identification"){
       		echo identification();
       }
       
	if ($_GET["page"]=="ancien_article"){ // Consultation de la liste de tous les articles
          	echo afficher_titre_article();
       }         
	
	if ($_GET["page"]=="mes_articles"){ // Consultation des articles publiés par l'utilisateur
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
	echo afficher_footer(); // On affiche le footer a chaque page
         ?>
</footer>
	   <br/>
	   <div class=fixe> <a href=index.php> Retourner à l'accueil </a> 
	   <a href=#haut_de_page>Haut de page </a></div>
       </body>
	   
</html>
