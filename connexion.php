<?php
function connexion(){
    if (isset($_SESSION["nom"])){ // Protection si l'utilisateur essaye de transformer l'url pour se connecter 2 fois 
       return "Vous êtes déjà connecté<br/>";
       }
    return "
           <form action=\"index.php?page=identification\" method=\"post\">
                 ID:<input type=\"text\" name=\"nickname\"><br/>
                 PASSWORD:<input type=\"password\" name=\"mdp\"><br/>
                 <input type=\"submit\" value=\"Connexion\"><br/>
           </form><br>"; // renvoie le formulaire pour se connecter
}
?>
       
       
