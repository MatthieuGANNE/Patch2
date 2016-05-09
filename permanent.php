<?php
function afficher_header(){
  $s="<div class=droite>".accueil();
  if (isset($_SESSION["mail"])){
	  $mail=true;
	 $s.="<a href=\"index.php?page=modifier\">Modifiez mon profil</a> ";
     $s.="<a href=\"index.php?page=deconnexion\">Deconnexion</a></div>";
	  if ($_SESSION["rank"]==1){
		  $rank=true;
	  }
  } else {
	  $s.="</div>";
  }
   
  $s.="<h1> Ceci est un site</h1>";
  $s.="<div class=menu><a href=\"index.php?page=ancien_article\">Ancien article</a>";
  if (isset($mail)){
	  $s.="<a href=\"index.php?page=mes_articles\">Mes articles</a>";
	  $s.="<a href=\"index.php?page=article_form\">Publier un article</a>";
	  if (isset($rank)){
		  $s.="<a href=\"index.php?page=moderation\">Gérer les comptes utilisateurs</a><a href=\"index.php?page=moderation_categorie\">Gérer les catégories</a></div>";
	  } else {
		  $s.="</div>";
	  }
     
  }
  return $s;
}

function afficher_footer(){
	$s="Sité crée par Matthieu GANNE et Florian SZCZEPANSKI<br>";
	
	
	return $s;
}
    
?>