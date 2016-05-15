<?php
/* Les tables de la base de donnée "blog" sont composées de la manière suivante:


users :

nom (varchar)
prenom (varchar)
id (int Auto_increment) primary
pseudo (varchar) unique
mail (varchar) unique
mdp (varchar)
rank (int)
styles (int)


article :

nom (varchar)
date (date)
id (int Auro_increment) primary
id_users (int)
contenu (mediumtext)
id_categorie(int)


categorie :

nom (varchar) unique
id ((int Auro_increment) primary


commentaire :

date (date)
id_users (int)
id_article (int)
id int Auro_increment) primary
contenu (varchar)*/
?>