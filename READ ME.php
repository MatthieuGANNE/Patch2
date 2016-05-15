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
contenu (varchar)

Le code SQL étant : 
  CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(256) NOT NULL,
  `prenom` varchar(256) NOT NULL,
  `pseudo` varchar(256) NOT NULL,
  `mail` varchar(256) NOT NULL,
  `mdp` varchar(256) NOT NULL,
  `rank` int(11) DEFAULT '0',
  `style` int(11) DEFAULT NULL,
  `bloque` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `mail` (`mail`)
)


DROP TABLE `article`;
CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contenu` text NOT NULL,
  `id_categorie` int(100) DEFAULT '0',
  `id_users` int(11) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) 



DROP TABLE `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) 


DROP TABLE `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_article` int(11) NOT NULL,
  `id_users` int(11) NOT NULL,
  `contenu` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) 
*/
?>
