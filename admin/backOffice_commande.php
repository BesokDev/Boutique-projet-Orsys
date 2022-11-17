<?php 
require_once('../include/init_inc.php');

if(!isAdminConnect())
{
    header('location:' . URL . 'connexion.php');
}

// AFFICHAGE DETAILS COMMANDE
if(isset($_GET['action']) && $_GET['action'] == 'detail') 
{
    if(isset($_GET['id_commande']) && !empty($_GET['id_commande']))
    {
        $select = $bdd->prepare("SELECT dc.produit_id AS ID,  p.photo, p.reference, p.titre, p.categorie, dc.quantite, dc.prix FROM details_commande dc INNER JOIN produit p ON dc.produit_id=p.id_produit AND dc.commande_id = :id_commande");

        $select->bindValue(':id_commande', $_GET['id_commande'], PDO::PARAM_INT);
        $select->execute();
        
        if(!$select->rowCount())
        {
           header('location:' . URL . 'admin/backOffice_commande.php');
        }
    }
    else
    {
        header('location:' . URL . 'admin/backOffice_commande.php');
    }
}
/*
    Exo : afficher la liste des commandes sous forme de tableau HTML contenant les colonnes suivantes :
        id_commande
        nom
        prenom
        email
        montant
        date_enregistrement
        etat
        edit, détail, supp

    JOINTURE SQL entre la table commande et la table membre
    BOUCLE + FETCH
*/

// TABLE DE JOINTURE
$query = $bdd->query("SELECT id_commande AS 'N° cmd', id_membre AS 'N° client', email, prenom, nom, adresse, DATE_FORMAT(date_enregistrement, '%d/%m/%Y à %H:%i:%s') AS 'DATE DE COMMANDE', montant, etat FROM membre INNER JOIN commande ON membre_id = id_membre");

require_once('../include/header_inc.php');
require_once('../include/nav_inc.php');
?>
<!-- //////////////////////////////////////////////////////////////////////////////////////// -->
<!-- ////////////////////////////////////////// HTML //////////////////////////////////////// -->
<!-- //////////////////////////////////////////////////////////////////////////////////////// -->


<!-- /////////////////////////////////////// AFFICHAGE COMMANDES //////////////////////////////////////////// -->

<?php if(empty($_GET) || $_GET['action'] == 'retour') : ?>
<h1 class="display-4 text-center mx-auto my-4">Liste des commandes</h1>

<div class="d-flex justify-content-between ml-2 mb-2">
    <h5><span class="badge badge-success"><?= $query->rowCount() ?></span> commande(s)</h5>
    <div class="form-row">
        <label for="search" class="mr-2">Trier par : </label>
        <input type="text" id="search" name="search" class="form-control-sm col-md-8 bg-light border border-info" placeholder="Rechercher">
    </div>
</div>
<table class="table table-bordered text-center">
    <tr>
        <?php   for($i=0; $i < $query->columnCount(); $i++) :
                $colonne = $query->getColumnMeta($i);
                // echo "<pre>"; print_r($colonne); echo "</pre>";
        ?>
            <th><?= strtoupper($colonne['name']) ?></th>
        <?php endfor; ?>

        <th class="text-success">VOIR</th>
        <th class="text-info">EDIT</th>
        <th class="text-danger">SUPP</th>
    </tr>

    <?php
        while($cmd = $query->fetch(PDO::FETCH_ASSOC)) : 
        // echo "<pre>"; print_r($cmd); echo "</pre>";
    ?>
    <tr>

        <?php foreach($cmd as $key => $value) : ?>

            <?php if($key == 'montant') :?>
                <td><?=$value?> €</td>
            <?php else :?>
                <td><?=$value?></td>
            <?php endif;?>

        <?php endforeach; ?>

        <td><a href="?action=detail&id_commande=<?=$cmd['N° cmd'] ?>" class="btn"><i class='far fa-eye text-success'></i></a></td>
        <td><a href="?action=edit&id_commande=<?=$cmd['N° cmd'] ?>" class="btn"><i class='fas fa-edit text-info'></i></a></td>
        <td><a href="?action=supp&id_commande=<?= $cmd['N° cmd'] ?>" class="btn" onclick="return confirm('Supprimer la commande ?');"><i class='fas fa-trash-alt text-danger'></i></a></td>
        
    </tr>
    <?php endwhile; ?>
</table>
<?php endif; ?>

<!-- /////////////////////////////////////// AFFICHAGE DETAILS COMMANDES //////////////////////////////////////////// -->


<?php if(isset($_GET['action']) && $_GET['action'] == 'detail') : ?>

    <h3 class="col-md-4 mx-auto my-4 text-center text-info bg-dark rounded">DÉTAILS COMMANDE</h3>
    <a href="?action=retour" class="btn btn-info mb-3 h4"><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-left-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-4.5.5a.5.5 0 0 0 0-1H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5z"/>
</svg> Retour</a>

    <table class="col-md-10 mx-auto table table-bordered text-center">

        <tr>
        <?php   for($i=0; $i < $select->columnCount(); $i++) :
                $colonne = $select->getColumnMeta($i);
                // echo "<pre>"; print_r($colonne); echo "</pre>";
        ?>
            <td><?= strtoupper($colonne['name']) ?></td>
        <?php endfor; ?>

        </tr>

        <?php while($detail = $select->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>
                <?php foreach($detail as $key => $value) : ?>

                    <?php if($key == 'photo') : ?>

                        <td><img src="<?= $value ?>" alt="<?= $detail['titre'] ?>" class="" style='width:100px;'></td>

                    <?php elseif($key == 'prix') : ?>

                        <td><?= $value ?> €</td>

                    <?php else : ?>
                    
                        <td><?= $value ?></td>

                    <?php endif; ?>   
                <?php endforeach; ?>

            </tr>

        <?php endwhile; ?>
    </table>

<?php endif; ?>


<?php require_once('../include/footer_inc.php'); ?>