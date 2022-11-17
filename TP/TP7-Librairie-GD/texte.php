<?php

# Définir une variable d'environnement pour GD2
putenv('GDFONTPATH=' . realpath('.'));

$fontFile = __DIR__ . '/Roboto-Regular.ttf';

# Création d'une ressource GD à partir de zéro d'une image. 
$image = imagecreatetruecolor(300, 300);
# Création de couleur
$red = imagecolorallocate($image, 0xFF, 0x00, 0x00);
$black = imagecolorallocate($image, 0x00, 0x00, 0x00);

# Défnition d'un rectangle rouge 
imagefilledrectangle($image, 0, 0, 300, 100, $red);

# Dessiner le texte en utilisant une font de taille 13
imagettftext($image, 13, 0, 10, 55, $black, $fontFile, '© Copyright');

# Maintenant que l'image est prête, on peut envoyer l'en-tête au navigateur.
header('Content-Type: image/png');

imagepng($image);
imagedestroy($image);
