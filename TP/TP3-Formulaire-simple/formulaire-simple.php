# Créer un formulaire avec un input prenom et un input select pour choisir une ville.
# Créer un tableau qui contiendra plusieurs noms de ville.
# Créer une fonction qui va générer autant d'options qu'il y a de villes dans votre array.
<?php
$villes = ['Bordeaux', 'Lyon', 'Paris', 'Lille', 'Marseille', 'Toulouse', 'Agen', 'Cahors', 'Perpignan'];

function genererUneListe($liste) {
    $html = '';

    foreach($liste as $element ) {
        $html .= "<option value='$element'>$element</option>";
    }

    return $html;
}

?>


<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<br>
    <form action="#" method="get">

        <label for="prenom">Quel est votre prénom ?</label>
        <input type="text" name="prenom" id="prenom">

        <br>
        <br>

        <label for="ville">Quelle ville habitez-vous ?</label>
        <select name="ville" id="ville">

        <?= genererUneListe($villes) ?>

        </select>
        <input type="submit" value="Valider" style="background-color: limegreen;">
    </form>

</body>
</html>