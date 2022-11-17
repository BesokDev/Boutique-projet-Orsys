<?php

//////////////////////////////////////////////////////////////////////////////////////
// ************************** FONCTION MEMBRE CONNECTÉ *****************************//
//////////////////////////////////////////////////////////////////////////////////////
function isConnect()
{
    if(!isset($_SESSION['membre'])) {
        return false;
    }

    return true;
}

/////////////////////////////////////////////////////////////////////////////////////
// ****************************** FONCTION ADMIN **********************************//
/////////////////////////////////////////////////////////////////////////////////////
function isAdminConnect()
{

    if(isConnect() && $_SESSION['membre']['statut'] == 1) {
        return true;
    } else {
        return false;
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
// *************************** FONCTION CREATION PANIER DANS LA SESSION **************************** //
///////////////////////////////////////////////////////////////////////////////////////////////////////
// Les données du panier ne sont jamais conservées en BDD, bcp de panier n'aboutissent pas à un paiement.
// Donc nous allons stocker les infos du panier directement dans le fichier $_SESSION du user.
// Dans la session, nous définissons différents ARRAY qui permettront de stocker par exemple toute les références des produits ajoutés au panier dans un ARRAY
function createCart()
{
    if(!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];  // création d'un ARRAY dans la session à l'indice ['panier']
    }
}


//echo $panier = serialize($_SESSION['panier']);
//
//    /*
//     Si on affiche maintenant la variable $panier, cela donne :
//     a:2: {
//     i:458;a:5:
//        {s:5:"photo";s:12:"photo458.jpg";s:9:"reference";s:6:"AB0001";s:5:"titre";s:9:"tee-shirt";s:8:"quantite";i:1;s:4:"prix";i:10;}
//     i:137;a:5:
//        {s:5:"photo";s:12:"photo137.jpg";s:9:"reference";s:6:"AB0054";s:5:"titre";s:7:"chemise";s:8:"quantite";i:1;s:4:"prix";i:45;}
//    }
//    */
//
//var_dump(unserialize($panier));


///////////////////////////////////////////////////////////////////////////////////////////////////////
// ************************** FONCTION AJOUTER AU PANIER DANS LA SESSION *************************** //
///////////////////////////////////////////////////////////////////////////////////////////////////////
// Les paramètres définit dans la fonction permettront de receptionner les informations du produit ajouté dans le panier afin de stocker chaque donnée dans les différents tableaux ARRAY
function add_ToCart($id_produit, $photo, $reference, $titre, $quantite, $prix): void
{
    if(!isset($_SESSION['panier'])) {
        createCart(); // On crée un panier s'il est INEXISTANT
    }

    // ***************** in_array() RETURN un BOOL ********************* //

    // SI la condition est vraie, cela veut dire que la fonction array_key_exists() a bien trouvé l'index du produit dans la session.
    if(array_key_exists($id_produit, $_SESSION['panier']))
    {
        $_SESSION['panier'][$id_produit]['quantite'] += $quantite; // On modifie la quantité du produit à l'index correspondant
    }
    else {
        $_SESSION['panier'][$id_produit] = [];
        $_SESSION['panier'][$id_produit] += ['photo' => $photo];
        $_SESSION['panier'][$id_produit] += ['reference' => $reference];   // e.g :  $_SESSION['panier'][458]['reference'] = AA0001
        $_SESSION['panier'][$id_produit] += ['titre' => $titre];
        $_SESSION['panier'][$id_produit] += ['quantite' => $quantite];
        $_SESSION['panier'][$id_produit] += ['prix' => $prix];   // e.g :  $_SESSION['panier'][458]['prix'] = 15
    }
}

///////////////////////////////////////////////////////////////////////////////////////////////////////
// ******************************** FONCTION MONTANT TOTAL PANIER ********************************** //
///////////////////////////////////////////////////////////////////////////////////////////////////////
function montantTotal(): float
{
    $total = 0;
//    for( $i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
    foreach ($_SESSION['panier'] as $id_produit => $produit) {
        $total += $produit['quantite'] * $produit['prix'];
    }
    return round($total); // arrondi $total à 0 chiffres après la virgule
} # end montantTotal

///////////////////////////////////////////////////////////////////////////////////////////////////////
// *************************** FONCTION Nombre Produit BADGE PANIER NAV **************************** //
///////////////////////////////////////////////////////////////////////////////////////////////////////
function nbreProduitPanier(): int
{
    if(isset($_SESSION['panier']))
    {
        $nombre = count($_SESSION['panier']);
    } else {
        $nombre = 0;
    }

    return $nombre;
} # end nbreProduitPanier()

///////////////////////////////////////////////////////////////////////////////////////////////////////
// ************************************ FONCTION DELETE ARTICLE PANIER ************************************* //
///////////////////////////////////////////////////////////////////////////////////////////////////////
function suppArticle($id_produit): void
{
    // array_key_exists() vérifie que l'index existe bien au sein du tableau panier
    $indexArticle = array_key_exists($id_produit, $_SESSION['panier']);

    // Si la valeur de $indexArticle est différente de FALSE, cela veut dire que l'id_produit à supprimer a bien été trouvé dans le panier de la session.
    if($indexArticle === true)
    {
          unset($_SESSION['panier'][$id_produit]);
    } # end if()
} # end suppArticle()

?>