<?php

# Création d'une ressource GD à partir de zéro d'une image. 
$image = imagecreatetruecolor(300, 300);
# Création de couleur
$red = imagecolorallocate($image, 0xFF, 0x00, 0x00);
$black = imagecolorallocate($image, 0x00, 0x00, 0x00);

# Défnition d'un rectangle rouge 
imagefilledrectangle($image, 0, 0, 300, 100, $red);



# Affichage de l'image sur le navigateur
header('Content-Type: image/png');

# Génération du fichier .png à partir de la ressource $image
imagepng($image);

# Pour libérer de la mémoire, on détruit la ressource (mais le fichier png)
imagedestroy($image);
