<?php 
require_once("include/init_inc.php");

switch (isset($_GET['action'])) {
    case "validSupp":
        $validSupp = "<div class='bg-light col-md-6 mx-auto mb-3 text-center rounded'>L'article a bien été retiré de votre panier.</div>";
        break;
    case "errorSupp":
        $errorSupp = "<div class='bg-light col-md-6 mx-auto mb-3 text-center rounded'>L'article n'a pas été supprimer de votre panier, veuillez recommencer.</div>";
        break;
    case "errorStock":
        $errorStock = "<div class='bg-dark col-md-4 mx-auto text-center text-white rounded'>Le stock a été actualisé et un problème est survenu.</div>";
        break;
}


if(isset($_POST['ajout_panier']))
{
//    var_dump($_POST); die();

    extract($_POST);

    $request= $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id");
    $request->bindValue(':id', $id_produit, PDO::PARAM_INT);
    $request->execute();

    $produit = $request->fetch(PDO::FETCH_ASSOC);
    // echo "<pre>"; print_r($produit); echo "</pre>";

    extract($produit);

    ///////////////////// $quantite est dans $_POST pas dans $produit //////////////////////
    add_ToCart($id_produit, $photo, $reference, $titre, $_POST['quantite'], $prix );

    // Redirection pour sortir de la méthode POST (HTTP)
    header("location: panier.php");
}

////////// SUPPRESSION ARTICLE DANS LE PANIER
if(isset($_GET['action']) && $_GET['action'] === 'suppArticle')
{

    if(array_key_exists($_GET['id_produit'], $_SESSION['panier'])) {

        suppArticle($_GET['id_produit']);

       header('location: panier.php?action="validSupp"');
    } else {
        header('location: panier.php?action="errorSupp"');
    }
}

if(isset($_POST["pay"]))
{

    foreach($_SESSION["panier"] as $id_produit => $produit) {
        $request = $bdd->query("SELECT stock FROM produit WHERE id_produit = ". $id_produit);
        $stock = $request->fetch(PDO::FETCH_ASSOC);
        //echo "<pre>"; echo "id_produit : " . $id_produit; echo "</pre>";
        echo "<pre>"; print_r($stock); echo "</pre>";

        // CONTROLE STOCK ARTICLE
        if($stock["stock"] < $produit["quantite"]) {
            $errorStock ="";
            $errorStock .= "<div class='bg-dark col-md-4 mx-auto text-center text-white rounded'>Stock restant du produit : $stock[stock]</div>";
            $errorStock .= '<div class="bg-info col-md-4 mx-auto my-2 text-center text-white rounded">Quantité demandée de l\'article : ' . $produit["quantite"] . '</div>';

            if($stock['stock'] > 0 ) {
                $errorStock .= '<div class="bg-light col-md-6 mx-auto mb-2 text-center text-danger border border-danger rounded">La quantité de l\'article : ' . '<span class="text-info">' . strtoupper($produit["titre"]) . '</span>' . ' à été modifié car le stock est insuffisant.</div>';

                $produit['quantite'] = $stock['stock'];
            }
            else {
                $errorStock .= '<div class="bg-danger col-md-6 mx-auto mb-2 text-center text-black rounded">L\'article : ' . '<span class="text-info">' . strtoupper($produit["titre"]) . '</span>' . ' à été supprimé car l\'article est en rupture de stock.</div>';

                suppArticle($id_produit); // suppression dans $_SESSION de l'article qui a un stock à 0, en rupture de stock.
                // on décrémente $i dans la boucle pour ne pas manquer un article, car array_splice à fait remonter tous les indexs suivants et à changé leur numéro (si le suivant est l'index [5], il devient [4] et on le controle bien)
            }

            $errorPanier = true;

            header('location: panier.php?action="errorStock"');
        }
    }

    if(!isset($errorPanier))
    {
        // INSERT DE LA COMMANDE DANS LA TABLE "commande"
        $request = $bdd->exec("INSERT INTO commande (membre_id, montant, date_enregistrement) VALUES (" . $_SESSION['membre']['id_membre'] . ", " . montantTotal() . ", NOW())");

        $idCommande = $bdd->lastInsertId(); // permet de recup le dernier id inséré dans la bdd afin de l'enregistrer dans la  table details_commande, pour chaque produit à la bonne commande

//        var_dump($idCommande); die();

        foreach($_SESSION["panier"] as $id_produit => $produit)
        {
            $req = $bdd->exec("INSERT INTO details_commande (commande_id, produit_id, quantite, prix) VALUES ($idCommande, " . $id_produit . ", " . $produit['quantite'] . ", " . $produit['prix']. ")");

            // DECREMENT des stocks d'article
            // Modifie la colonne 'stock' de la table 'produit' afin que le stock s'actualise en fonction des quantités commandées et de l'id_produit commandé
            $r= $bdd->exec("UPDATE produit SET stock=stock-" . $produit['quantite'] . " WHERE id_produit=" .$id_produit);
        }
        // On "vide" le panier du membre après le click du bouton 'valider mon paiement'
        unset($_SESSION['panier']);

        $_SESSION['num_cmd'] = $idCommande; // on stocke l'id_commande dans $_SESSION (à''num_cmd') après validation du panier

        header('location: validation_cmd.php'); // redirection du membre après la validation du paiement
    }
}

// echo "<pre>"; print_r($_SESSION); echo "</pre>";

require_once('include/header_inc.php');
require_once("include/nav_inc.php");
?>

<h1 class="display-4 text-center my-4">Mon Panier</h1>

<?php if(isset($errorStock)) echo $errorStock; ?>
<?php if(isset($validSupp)) echo $validSupp; ?>
<?php if(isset($errorSupp)) echo $errorSupp; ?>


<table class="col-md-9 mx-auto table table-bordered text-center">
    <thead>
        <tr>
            <th>PHOTO</th>
            <th>REFERENCE</th>
            <th>TITRE</th>
            <th>QUANTITE</th>
            <th>PRIX Unitaire</th>
            <th>PRIX Total/Produit</th>
            <th>SUPPRIMER</th>
        </tr>
    </thead>
    <tbody>
<?php if(empty($_SESSION['panier'])): ?>

        <tr>
            <td colspan="7" class="text-warning bg-dark">Aucun produit dans votre panier</td>
        </tr>

<?php else : ?>

<?php //for($i=0; $i < count($_SESSION['panier']) ; $i++): ?>
<?php foreach($_SESSION['panier'] as $id_produit => $produit): ?>

        <tr>
            <td><a href="fiche_produit.php?id_produit=<?= $id_produit ?>"><img src="<?= $produit['photo'] ?>" alt="<?= $produit['titre'] ?>" style="width:100px;"></a></td>

            <td><?= $produit['reference'] ?></td>
            <td><?= $produit['titre'] ?></td>
            <td><?= $produit['quantite'] ?></td>
            <td><?= $produit['prix'] ?>€</td>
            <td><?= $produit['quantite'] * $produit['prix'] ?>€ </td>

            <td><a href="?action=suppArticle&id_produit=<?= $id_produit?>" class="btn"><i class='fas fa-trash-alt text-danger'></i></a></td>


        </tr>

<?php endforeach; ?>

        <tr>
            <th class="bg-dark text-white">Montant TOTAL</th>
            <td colspan="4" class="bg-dark"></td>
            <th class="bg-dark text-white"><?= montantTotal(); ?>€</th>
            <td class="bg-dark"></td>
        </tr>

    </tbody>

<?php endif; // end else ?>


<tfoot>
<!--    <div class="col-9 mx-auto">-->
<tr>
    <td colspan="7">

        <?php if(!isConnect()) : ?>
            <a href="<?= URL ?>connexion.php" class="col-10 btn btn-info">Identifiez-vous</a>

        <?php elseif(empty($_SESSION['panier'])) : ?>
            <a href="<?= URL ?>boutique.php" class="col-10 btn btn-warning">Aller à la boutique</a>

        <?php else : ?>
            <form action="" method="POST">
                <input type="submit" name="pay" value="Valider mon paiement" class="col-10 btn btn-success">
            </form>
        <?php endif; ?>

    </td>
</tr>


<!--    </div>-->
</tfoot>

</table>

<?php require_once("include/footer_inc.php"); ?>
