<?php

header('Content-Type: image/png');

$imgSource = imagecreatefrompng("uploads/orsysNew.png");
$imgDestination = imagecreatefrompng('uploads/pont.png');
// var_dump($imgSource); die;

# Récupération des valeurs de la taille du fichier source
$detailsSource = getimagesize("uploads/orsysNew.png");

# Cette variable $y permet de stocker la position du logo sur l'axe vertical (y)
$y = imagesy($imgDestination) - imagesy($imgSource);
$x = (imagesx($imgDestination) - imagesx($imgSource)) - 50;

# Appel de la fonction pour fusionner les 2 images.
imagecopy($imgDestination, $imgSource, 15, $y, 0, 0, $detailsSource[0], $detailsSource[1]);

imagepng($imgDestination);
imagedestroy($imgSource);
imagedestroy($imgDestination);
