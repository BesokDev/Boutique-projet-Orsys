<?php

// setcookie('panier_id_produit', '425', [
//     'expires' => time() + 3600,
//     'secure' => false,
//     'httponly' => true
// ]);
// setcookie('panier_produit_425_nom', 'tee-shirt', [
//     'expires' => time() + 3600,
//     'secure' => false,
//     'httponly' => true
// ]);
// setcookie('panier_produit_425_prix', '25', [
//     'expires' => time() + 3600,
//     'secure' => false,
//     'httponly' => true
// ]);
// setcookie('panier_produit_425_quantite', '2', [
//     'expires' => time() + 3600,
//     'secure' => false,
//     'httponly' => true
// ]);


setcookie('panier_id_produit', '', [
    'expires' => time() - 3600
]);

var_dump($_COOKIE);


?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COOKIE</title>
</head>
<body>

<h1>Les cookies</h1>

<div>

    <p>Vos cookies contiennent les informations de votre panier</p>
    <ul>
        <li>L'identifiant de votre produit est : <?= $_COOKIE['panier_id_produit'] ?> </li>
        <li>Le nom du produit est : <?= $_COOKIE['panier_produit_425_nom'] ?> </li>
        <li>Le prix du produit est : <?= $_COOKIE['panier_produit_425_prix'] ?> €</li>
        <li>La quantité selectionnée est : <?= $_COOKIE['panier_produit_425_quantite'] ?> </li>
        <li>Le total du panier s'élève à : <?= $_COOKIE['panier_produit_425_prix'] * $_COOKIE['panier_produit_425_quantite'] ?> €</li>
    </ul>

</div>
</body>
</html>