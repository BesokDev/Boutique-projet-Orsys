<?php

# Gestion avec un fichier font (.ttf)

# Définition de la variable d'environnement GD
putenv('GDFONTPATH='. realpath('.'));

$fontFile = __DIR__ . '/Roboto-Regular.ttf';

$image = imagecreatefrompng("uploads/pont.png");

# Définition de la couleur du texte, avec une couche de transparence (alpha)
$blanc = imagecolorallocatealpha($image, 255, 255, 255, 70);

imagettftext($image, 32, 0, 50, imagesy($image)-50, $blanc, $fontFile, "Copyright" . '-' . date('Y'));

header('Content-Type: image/png');

$path = "uploads/new.png";
imagepng($image, $path);
imagedestroy($image);