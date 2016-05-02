<?php
function afficher_header(){
$r="<p>";
  $s="<h1>Ceci est un site</h1>";
  if (isset($_SESSION["inscrit"])){
     $r.="<a href=\"index.php?page=modifier\">Modifiez mon profil</a> <br>";
     $r.="<a href=\"index.php?page=deconnexion\">Deconnexion</a>";
  } else {
     $r.="<a href=\"index.php?page=connexion\">Connexion</a> <br> <a href=\"index.php?page=inscription\">Inscription</a>";
  }
  $r.="</p>";
  $s.=$r;
  return $s;
}

function afficher_footer(){
}
    
?>