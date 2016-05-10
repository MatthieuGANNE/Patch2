<?php
function connexion(){
    if (isset($_SESSION["nom"])){
       return "Vous êtes déjà connecté<br/>";
       }
    return "
           <form action=\"index.php?page=identification\" method=\"post\">
                 ID:<input type=\"text\" name=\"nickname\"><br/>
                 PASSWORD:<input type=\"password\" name=\"mdp\"><br/>
                 <input type=\"submit\" value=\"Connexion\"><br/>
           </form><br>";
}
?>
       
       
