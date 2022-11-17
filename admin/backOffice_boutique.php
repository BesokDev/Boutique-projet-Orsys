<?php
require_once('../include/init_inc.php');

extract($_POST);

if(!isAdminConnect())
{
    header('location: ' . URL . 'connexion.php');
}
//////////////////////////////////////////////////////////////////////////////////////////////
// ************************************** SUPPRESSION ARTICLE ***************************** //
//////////////////////////////////////////////////////////////////////////////////////////////
// ON entre dans la condition IF seulement dans le cas où l'internaute à cliqué sur un lien suppression produit et par conséquent a transmit dans l'URL les paramètres 'action=suppresion'
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    $supp = $bdd->prepare('DELETE FROM produit WHERE id_produit= :id');
    $supp->bindValue(':id', $_GET['id_produit'], PDO::PARAM_INT);
    $supp->execute();

    // header("location:" . URL . 'admin/backOffice_boutique.php?action=affichage');
    $_GET['action'] = 'affichage';

    $confirmSupp = "<p class='col-md-4 mx-auto bg-success text-center text-white p-4 rounded'>Article ID $_GET[id_produit] supprimé</p>";
}

// ENREGISTREMENT ARTICLE/PRODUIT
if($_POST)
{
    // TRAITEMENT DE LA PHOTO UPLOADÉE
    $photoBdd= "";

    // TRAITEMENT DE LA PHOTO MODIF
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $photoBdd = $_POST['photo_modif'];
    }

    if(!empty($_FILES['photo']['name']))
    {
        $nomPhoto= $_POST['ref'] . '-' . $_FILES['photo']['name'];
        // echo $nomPhoto;

        // on défini l'URL avec le nom de la photo
        $photoBdd= URL . "photo/$nomPhoto";
        // echo $photoBdd;

        // on défini le chemain physique de la photo
        $photoDossier = RACINE_SITE . "photo/$nomPhoto";
        // echo $photoDossier;

        // fonction définie pour copier un fichier
        // arguments : 
        // 1 - le nom temporaire  de l'image accessible dans la superglobale $_FILES
        // 2 - le chemin physique de la photo jusqu'au dossier photo sur le serveur
        copy($_FILES['photo']['tmp_name'], $photoDossier);
    }

    if (isset($_GET['action']) && $_GET['action'] == 'ajout')
    {
        // INSERTION BDD
        $data = $bdd->prepare("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:ref, :cat, :titre, :descript, :couleur, :taille, :public, :photo, :prix, :stock)");

        $_GET['action'] = 'affichage';

        $confirm = "<span class='d-block col-md-6 mx-auto mb-3 bg-success text-center text-white p-4 rounded'>L'article $_POST[titre], référence $_POST[ref] à bien été ajouté</span>";
    }
    else
    {
        //UPDATE BDD
        $data = $bdd->prepare("UPDATE produit SET reference = :ref, categorie = :cat, titre = :titre, description = :descript, couleur = :couleur, taille = :taille, public = :public, photo = :photo, prix = :prix, stock = :stock WHERE id_produit = :id");

        $data->bindValue(":id", $_GET["id_produit"], PDO::PARAM_INT);

        $_GET["action"] = "affichage";

        $confirm = "<p class='col-md-5 mx-auto bg-success text-center text-white p-4 rounded'>L'article $_POST[titre], référence $_POST[ref] à bien été modifié</p>";
    }
    

    $data->bindValue(':ref', $ref, PDO::PARAM_STR);
    $data->bindValue(':cat', $cat, PDO::PARAM_STR);
    $data->bindValue(':titre', $titre, PDO::PARAM_STR);
    $data->bindValue(':descript', $descript, PDO::PARAM_STR);
    $data->bindValue(':couleur', $couleur, PDO::PARAM_STR);
    $data->bindValue(':taille', $taille, PDO::PARAM_STR);
    $data->bindValue(':public', $public, PDO::PARAM_STR);
    $data->bindValue(':photo', $photoBdd, PDO::PARAM_STR);
    $data->bindValue(':prix', $prix, PDO::PARAM_INT);
    $data->bindValue(':stock', $stock, PDO::PARAM_INT);

    $data->execute();
}


require_once('../include/header_inc.php');
require_once("../include/nav_inc.php");
?>

<!-- LIENS ARTICLES HTML -->
<ul class="shadow p-0 col-md-5 mx-auto mt-5 list-group text-center">
  <li class="list-group-item bg-dark text-white h1">Gestion Boutique / Article</li>
  <li class="list-group-item"><a href='?action=affichage' class="col-md-8 btn btn-info">Affichage Articles</a></li>
  <li class="list-group-item"><a href='?action=ajout' class="col-md-8 btn btn-info">Ajouter un Article</a></li>
</ul>

<?php
/////////////////////////////////////// AFFICHAGE TABLE ARTICLE //////////////////////////////

// SI l'indice 'action' est bien définit dans l'URL et qu'il a pour valeur 'affichage', cela veut dire que l'internaute a cliqué sur le lien 'AFFICHAGE PRODUITS' et par conséquent que les paramètres 'action=affichage' ont été transmit dans l'URL
if(isset($_GET["action"]) && $_GET["action"] == "affichage")
{
    echo    '<hr class="mt-5">';
    echo    '<h1 class="display-4 mx-auto text-center text-info">Articles Enregistrés</h1>';
    echo    '<hr>';

    // Affichage message to user
    if(isset($confirmSupp)) echo $confirmSupp;
    if(isset($confirm)) echo $confirm;


    $query= $bdd->query("SELECT * FROM produit");

    echo "<table class='table table-bordered text-center'><tr>";
    for($i=0; $i < $query->columnCount(); $i++)
    {
        $column = $query->getColumnMeta($i);
        // echo "<pre>"; print_r($column); echo "</pre>";
        echo "<th>" . strtoupper($column['name']) . "</th>";
    }
        echo "<th class='text-info'>EDIT</th>";
        echo "<th class='text-info'>SUPP</th>";
    echo "</tr>";

   $resultats = $query->fetch(PDO::FETCH_ASSOC) ;
//

    while($resultats = $query->fetch(PDO::FETCH_ASSOC))
    {
        // echo "<pre>"; print_r($produit); echo "</pre>";

        echo "<tr>";
        foreach($resultats as $key => $value)
        {
            if($key === 'photo')
            {
                echo "<td class='align-middle'><img src='$value' alt='' class='w-50 h-50'></td>";  
            }
            elseif ($key === 'prix')
            {
                echo "<td class='align-middle'><span>$value</span> €</td>";
            }
            else
            {
                echo "<td class='align-middle'>$value</td>";
            }
        }
            echo "<td><a href='?action=modification&id_produit=$resultats[id_produit]'><i class='fas fa-edit'></i></a></td>";
            echo "<td><a href='?action=suppression&id_produit=$resultats[id_produit]' onclick='return(confirm(\"Supprimer le produit ?\"));'><i class='fas fa-trash-alt text-danger'></i></a></td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<!-- enctype="multipart/form-data" : si le formulaire contient un upload de fichier , il ne faut pas oublier l`attribut ENCTYPE et la valeur "multipart/form-data" qui permettent de stocker les infos du fichier uploadé directement dans la SUPERGLOBALE $_FILES-->

<?php 
if(isset($_GET["action"]) && ($_GET["action"] === "ajout" || $_GET["action"] === "modification")):
    
    if(isset($_GET["id_produit"]) && !empty($_GET["id_produit"]))
    {
        // On selectionne toute la BDD à condition que l'id_produit soit égal à l'id_produit dans l'URL
        // On selectionne toute les données en BDD du produit que l'on souhaite modifier
        $result = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id");
        $result->bindValue(':id', $_GET['id_produit'], PDO::PARAM_INT);
        $result->execute(); 

        // Si la requete SELECT retourne 1 résultat, le produit est connu en BDD; on entre dans la condition IF 
        if($result->rowCount()) {
            $produitModif = $result->fetch(PDO::FETCH_ASSOC);
            //echo '<pre>'; print_r($produitModif); echo '</pre>';
        }
        // Sinon l'id_produit de l'URL n'est pas connu en BDD, on redirige vers l'affichage des produits 
        else
        {
            header('location:' . URL . 'admin/backOffice_boutique.php?action=affichage');
        }
    }
    elseif($_GET['action'] === 'modification' && (!isset($_GET['id_produit']) || empty($_GET['id_produit'])))
    {
        header('location:' . URL . 'admin/backOffice_boutique.php?action=affichage');
    }

    // $ref = variable DE RECEPTION de la CONDITION TERNAIRE if else. $ref reçoit la valeur de l'id retourné par $result->fetch => ($produitModif)
    $ref= (isset($produitModif['reference'])) ? $produitModif['reference'] : '';
    $cat= (isset($produitModif['categorie'])) ? $produitModif['categorie'] : '';
    $titre= (isset($produitModif['titre'])) ? $produitModif['titre'] : '';
    $descript= (isset($produitModif['description'])) ? $produitModif['description'] : '';
    $couleur= (isset($produitModif['couleur'])) ? $produitModif['couleur'] : '';
    $taille= (isset($produitModif['taille'])) ? $produitModif['taille'] : '';
    $public= (isset($produitModif['public'])) ? $produitModif['public'] : '';
    $photo= (isset($produitModif['photo'])) ? $produitModif['photo'] : '';
    $prix= (isset($produitModif['prix'])) ? $produitModif['prix'] : '';
    $stock= (isset($produitModif['stock'])) ? $produitModif['stock'] : '';

?>

<?php
$class = 'text-danger';
$addClass = (isset($_GET['action']) && $_GET['action'] === 'modification') ? $class : '';
?>
    
<!-- enctype="multipart/form-data" : si le formulaire contient un upload de fichier , il ne faut pas oublier l`attribut "enctype"  et la valeur `multipart/form-data` qui permettent de stocker les infos du fichier uploadé directement dans la SUPERGLOBALE $_FILES -->
<form class="col-md-6 mx-auto mb-4 bg-info rounded" method="POST" enctype="multipart/form-data">

<div class="my-3">
<!-- On va crocheter à l'indice 'action' dans l'URL afin de modifier le titre en fonction d'un `ajout` ou d'une `modification` de produit
ucfirst() : fonction prédéfinie permettant d'afficher la première lettre d'une chaine de caractères en majuscule -->
<h3 class="mt-5 text-center text-white bg-dark rounded mx-auto p-2"><?= ucfirst($_GET["action"]) ?> Article</h3>


    <div class="form-group">
        <label for="ref">Référence</label>
        <input type="text" id="ref" name="ref" class="form-control <?= $addClass?>" value="<?= $ref?>">
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="cat">Catégorie</label>
            <input type="text" id="cat" name="cat" class="form-control <?= $addClass?>" value="<?= $cat?>">
            
        </div>
        <div class="form-group col-md-6">
            <label for="titre">Titre Article</label>
            <input type="text" id="titre" name="titre" class="form-control <?= $addClass?>" value="<?= $titre?>">
        </div>
    </div>

    <div class="form-group">
        <label for="descript">Description</label>
        <textarea type="text" id="descript" name="descript" class="form-control <?= $addClass?>" rows="5"><?= $descript?></textarea>
    </div>


    <div class="form-row mt-5">

        <div class="form-group col-md-4">
            <div class="input-group col-auto">
                <div class="input-group-prepend">
                    <span class="input-group-text">Couleur</span>
                </div>
                <input type="text" id="couleur" name="couleur" class="form-control <?= $addClass?>" value="<?= $couleur?>">
            </div>  
        </div>

        <div class="form-group col-md-4">
            <div class="input-group col-auto">
                <div class="input-group-prepend">
                    <span class="input-group-text">Taille</span>
                </div>
                <select name="taille" id="taille" class="custom-select form-control <?= $addClass?>">
                    <option value="S">S</option>
                    <option value="M" <?php if ($taille == 'M') echo 'selected';?>>M</option>
                    <option value="L" <?php if ($taille == 'L') echo 'selected';?>>L</option>
                    <option value="XL" <?php if ($taille == 'XL') echo 'selected';?>>XL</option>
                </select>
            </div>
        </div>

        <div class="form-group col-md-4">
            <div class="input-group col-auto">
                <div class="input-group-prepend">
                    <span class="input-group-text">Public</span>
                </div>
                <select name="public" id="public" class="custom-select form-control <?= $addClass?>">
                    <option value="mixte" >Mixte</option>
                    <option value="homme" <?php if ($public == 'homme') echo 'selected';?> >Homme</option>
                    <option value="femme" <?php if ($public == 'femme') echo 'selected';?> >Femme</option>
                </select>
            </div>
        </div>

    </div>

    <div class="form-group my-4">
        <label for="photo">Photo</label>
        <input type="file" id="photo" name="photo" class="form-control-file">
    </div>

     <!-- On déclare un champ type hidden afin de récupérer l'URL de l'image pour la renvoyer dans la BDD si l'internaute en cas de modification ne souhaite pas modifier l'image -->
    <input type="hidden" id="photo_modif" name="photo_modif" value="<?=$photo?>">

    <!-- Affiche de la photo actuelle de l'article en cas de modification -->
    <!-- Un champ de type 'file' ne pas avoir d'attribue 'value', c'est pourquoi nous définissons un champ de type 'hidden' ci-dessous afin de récupérer l'URL de la photo en cas de modification -->
    <?php if(!empty($photo)) : ?>
        <div class="text-center">
            <p class="text-info">Vous pouvez choisir une nouvelle photo pour votre article</p>
            <img src="<?= $photo ?>" alt="<?= $titre ?>" class="w-25 h-25">
        </div>
    <?php endif; ?>

  
    <div class="form-row mt-5">
        <div class="form-group col-md-6">
            <label for="prix">Prix</label>
            <input type="text" id="prix" name="prix" class="form-control <?= $addClass?>" value="<?= $prix?>">
        </div>

        <div class="form-group col-md-6">
            <label for="stock">Stock/Quantités</label>
            <input type="text" id="stock" name="stock" class="form-control <?= $addClass?>" value="<?= $stock?>">
        </div>

    </div>

    <div class="">
        <button type="submit" class="col-md-4 offset-md-4 mb-5 btn btn-success"><?= strtoupper($_GET['action']) ?> ARTICLE</button>
    </div>
    </div>
</form>

<?php endif; ?>

<?php require_once("../include/footer_inc.php"); ?>