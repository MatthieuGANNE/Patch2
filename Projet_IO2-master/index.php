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
    <?php
       include "permanent.php";
       include "inscription.php";
       include "sauvegarde.php";
       include "accueil.php";
       include "preferences.php";
       include "connexion.php";
       include "article.php";
       include "identification.php";
       ?>
    <header>
      <?php
         echo afficher_header();
         ?>
    </header>
    <?php
       if (!isset($_GET["page"])){
			echo acceuil();
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
       if($_GET["page"]=="article")
           echo afficher_article($_get["id"]);
		
		if($_GET["page"]=="article_form")
				article_form();
			
		if($_GET["page"]=="sauvegarde_article")
				article_sauvegarde();

       if ($_GET["page"]=="identification"){
          echo identification();
       }
       
          
       
       }
       ?>
       </body>
</html>
