<?php

/////////////////////////////////////////////////////////////
// ******************** CONNEXION BDD ******************** //
// LOCAL HOST = Création d'une connexion à la BDD du projet avec la classe PDO
$bdd = new PDO('mysql:host=localhost;dbname=boutique', 'root', '');

/////////////////////////////////////////////////////////////
// ********************** SESSION ************************ //

# Démarrage d'une session utilisateur, pour le panier.
session_start();

////////////////////////////////////////////////////////////////////
// *********************** CONSTANTES (chemin) ****************** //

# Defini une constante de chemin physique sur le pc pour le serveur
define("RACINE_SITE", $_SERVER["DOCUMENT_ROOT"] . "/Boutique-projet/"); // $_SERVER['DOCUMENT_ROOT'] = C://xampp/htdocs

// Cette constante retourne le chemin physique du dossier 09-boutique sur le serveur local xampp.
// Lors de l'enregistrement d'une image/photo, nous aurons besoin du chemin physique complet vers le dossier photo sur le serveur pour enregistrer la photo dans le bon dossier
// On appelle $_SERVER['DOCUMENT_ROOT'] parce que chaque serveur possède des chemins différents.


// echo RACINE_SITE . '<hr>'; // = C:/xampp/htdocs/PHP/09-Boutique/ 

/*ON AURA PLUS QU'A CONCATAINER LE NOM DU DOSSIER POUR ACCEDER AUX DIFFERENTS DOSSIERS
====>  RACINE_SITE . 'photo'; ===> pour acceder au dossier 'photo'
*/

define("URL", "http://localhost:80/Boutique/");
// cette constante sert à enregistrer l'URL d'une image ou photo dans la BDD

// INFINITY FREE
// define("URL", "http://nevergrowup-boutique.rf.gd/");


////////////////////////////////////////////////////////////////////
// *********************** INCLUSION ****************** //
require_once('fonctions_inc.php');
// en appelant init_inc.php sur chaque fichier, on inclut en même temps les fonctions déclarées

?>