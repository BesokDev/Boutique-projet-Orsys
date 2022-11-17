<?php

if(empty($_SESSION)) {
    # Pour ceréer une session on utilise la fonction native suivante :
    session_start();
}

# Si le panier n'existe pas, on le créer. C'est un array dans la session.
if( !isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];

    $_SESSION['panier'] = [

        425 => [
            'nom' => 'tee-shirt',
            'prix' => 25,
            'quantite' => 2
        ]
    ];
}

if(isset($_GET['action'])) {

    if($_GET['action'] === 'ajouter-produit') {
        $_SESSION['panier'][425]['quantite']++;
        header('location: creer-manipuler-session.php');
    }

    if($_GET['action'] === 'supprimer-produit') {
        $_SESSION['panier'][425]['quantite']--;
        header('location: creer-manipuler-session.php');
    }

    if($_GET['action'] === 'vider-panier') {
        unset($_SESSION['panier']);
        header('location: creer-manipuler-session.php');
    }

}

var_dump($_SESSION);

echo session_name();
echo '<br>';
echo session_save_path();
echo '<br>';
echo session_module_name();
echo '<br>';

# La fonction serialize() permet de générer une string qui contiendra les valeurs et leur organisation.
$panierSerialize = serialize($_SESSION['panier']);

# unserialize() fait l'inverse la fonction ci-dessus.
var_dump(unserialize($panierSerialize));



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        th, tfoot>tr>td {
            border: 2px black solid;
        }
        th, td {
            margin: 10px;
            text-align: center;
            vertical-align: center;
        }
    </style>
</head>
<body>
    
    <h1>La session - Faire un panier</h1>

    <table>
        <thead>
            <tr>
                <th>Identifiant du produit</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Ajouter un exemplaire</th>
                <th>Supprimer un exemplaire</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalCommande = 0; ?>
            <?php foreach($_SESSION['panier'] as $id => $produit) : ?>
                <tr>
                    <td><?= $id ?></td>
                    <td><?= $produit['nom'] ?></td>
                    <td><?= $produit['prix'] ?> €</td>
                    <td><?= $produit['quantite'] ?></td>
                    <td><a href="?action=ajouter-produit">+1</a></td>
                    <td><a href="?action=supprimer-produit">-1</a></td>
                    <td><?= $produit['prix'] * $produit['quantite'] ?> €</td>
                </tr>
            <?php $totalCommande += $produit['prix'] * $produit['quantite'] ?>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan='6'>TOTAL DE LA COMMANDE</td>
                <td><?= $totalCommande ?> €</td>
            </tr>
        </tfoot>
    </table>

    <br>

    <div>
        <a href="creer-manipuler-session.php?action=vider-panier">Vider votre panier</a>
    </div>

</body>
</html>