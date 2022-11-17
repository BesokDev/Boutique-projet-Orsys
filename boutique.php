<?php 
require_once("include/init_inc.php");

// SI l'indice 'categorie' est bien définit dans l'URL et que sa valeur n'est pas vide, cela veut dire que l'internaute a clkiqué sur un lien de catégorie et par conséquent transmit les paramètre ex : 'categorie=tee-shirt'
if (isset($_GET['categorie']) && !empty($_GET['categorie']))
{
     // On selectionne tout en BDD par rapport à la catégorie transmise dans l'URL, afin d'afficher tout les produits liés à la catégorie
    $request = $bdd->prepare("SELECT * FROM produit WHERE categorie = :cat");
    $request->bindValue(':cat', $_GET['categorie'], PDO::PARAM_STR);

    $resultat = $request->execute();

    if(!$request->rowCount())
    {
        header("location: boutique.php");
    }
}
else
{
    $request = $bdd->query("SELECT * FROM produit");
}

require_once('include/header_inc.php');
require_once("include/nav_inc.php");

?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="fixed-top col-lg-3" style="top:8%; left:7%;">

            <?php $cat=$bdd->query("SELECT DISTINCT categorie FROM produit");?>

            <h1 class="my-4 text-center">Tous les articles</h1>
            <div class="list-group text-center">
            <li class="list-group-item bg-dark" style="color:darkorange;">CATÉGORIE</li>

                <?php while($nomCat = $cat->fetch(PDO::FETCH_ASSOC)) :
                ///////////************* fetch() renvoie un seul array // fetchAll() renvoie un array multi *********///////////
                // echo "<pre>"; print_r($nomCat); echo "</pre>";
                ?>
                
                <a href="?categorie=<?= $nomCat['categorie'] ?>" style="text-decoration :none;" class='list-group-item text-center text-black'><?= $nomCat['categorie'] ?></a>

                <?php endwhile;?>
            </div>

        </div>
    <!-- /.col-lg-3 -->

        <div class="col-lg-9 mt-5" style="left:30%;">

<!--            <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">-->
<!--                <ol class="carousel-indicators">-->
<!--                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>-->
<!--                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>-->
<!--                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>-->
<!--                </ol>-->
<!--                <div class="carousel-inner" role="listbox">-->
<!--                    <div class="carousel-item active">-->
<!--                    <img class="d-block img-fluid" src="--><!--photo/slider1.png" alt="How to pay on internet">-->
<!--                    </div>-->
<!--                    <div class="carousel-item">-->
<!--                    <img class="d-block img-fluid" src="--><!--photo/slider2.jpg" alt="How to improve your e-commerce">-->
<!--                    </div>-->
<!--                    <div class="carousel-item">-->
<!--                    <img class="d-block img-fluid" src="--><!--photo/slider3.jpg" alt="Are you happy, opinion less or sad about your experience ?">-->
<!--                    </div>-->
<!--                </div>-->
<!--              ///////////// CONTROLS PREV & NEXT /////////////// -->
<!--                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">-->
<!--                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--                    <span class="sr-only">Previous</span>-->
<!--                </a>-->
<!--                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">-->
<!--                    <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--                    <span class="sr-only">Next</span>-->
<!--                </a>-->
<!--            </div>-->

            <div class="row">

            <?php while($produit = $request->fetch(PDO::FETCH_ASSOC)) :
                // echo "<pre>"; print_r($produit); echo "</pre>";
                extract($produit);
                ?>

                <div class="col-lg-4 col-md-6 m-2 shadow-lg p-2 bg-white rounded">
                    <div class="card h-100">
                        <a href="fiche_produit.php?id_produit=<?= $produit['id_produit'] ?>" class=" img-produit">
<!--                            <div class="wrapper-hidden">Voir le produit</div>-->
                            <img class="card-img-top" src="<?= $photo ?>" alt="Une photo manquante d'un article">
                        </a>
                        <div class="card-body mb-1">
                            <h4 class="card-title">
                                <p class="text-info"><?= ucfirst($titre) ?></p>
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

            <?php endwhile; ?>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.col-lg-9 -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container -->




<?php require_once("include/footer_inc.php"); ?>
