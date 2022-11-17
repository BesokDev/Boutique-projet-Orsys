<?php
require_once('include/init_inc.php');
require_once('include/header_inc.php');
require_once('include/nav_inc.php');

if (!empty($_GET['search_query'])) {
    extract($_GET);

    $requete = $bdd->query("SELECT * FROM produit WHERE 
    categorie LIKE '%$search_query%' OR
    titre LIKE '%$search_query%' OR
    description LIKE '%$search_query%';
    ");

    if($requete->execute() !== false) {
        $resultat_produit = $requete->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<?php if($resultat_produit) : ?>

    <?php foreach($resultat_produit as $produit) : ?>
    <?php extract($produit); ?>
    
        <div class="col-lg-4 col-md-6 m-2 shadow-lg p-2 bg-white rounded">
            <div class="card h-100">
                <a href="fiche_produit.php?id_produit=<?= $id_produit ?>" class=" img-produit">
                    <img class="card-img-top" src="<?= $photo ?>" alt="Une photo manquante d'un article">
                </a>
                <div class="card-body mb-1">
                    <h4 class="card-title">
                        <span class="text-info"><?= ucfirst($titre) ?></span>
                    </h4>
                    <div class="col mb-3">
                        <h5 class="">- Couleur : <?= strtolower($couleur) ?></h5>
                        <h5 class="">- Taille : <?= $taille ?></h5>
                        <h5 class="">- Prix : <?= $prix ?>€</h5>
                    </div>
                    <p class="card-text border border-info p-2 rounded"><?= $description ?></p>
                </div>
                <div class="card-footer">
                    <a href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="btn btn-info">Fiche produit</a>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
<?php endif; ?>



<?php require_once('include/footer_inc.php'); ?>

