<?php

$filename = "uploads/pont.png";
$texte = "Copyright";

header('Content-Type: image/png');

$image = imagecreatefrompng($filename);

# Créer une couleur pour le texte (ici, en blanc)
$textColor = imagecolorallocate($image, 255, 255, 255);

# Génération d'une valeur pour la position en y
$y = imagesy($image) - (48/2);

imagestring($image, 5, 15, $y, $texte, $textColor);

imagepng($image);
imagedestroy($image);