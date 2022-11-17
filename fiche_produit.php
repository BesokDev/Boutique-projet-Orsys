<?php 
require_once("include/init_inc.php");

/*
    1. réalsier le traitement SQL + PHP permettant de selectionnés les données du produit par rapport à l'id_produit transmis dans l'URL
    2. Faites en sorte que si l'id_produit dans l'URL n'est pas définit ou sa valeur est vide, de re-diriger vers la page boutique
    3. Si la requete de selection ne retourne aucun produit de la BDD, faites en sorte de re-diriger vers la page boutique
    4. Afficher les détails du produit dans l'affichage HTML, dans les div ci-dessous 
*/

if(isset($_GET['id_produit']) && !empty($_GET['id_produit']))
{
    $request = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id");
    $request->bindValue(':id', $_GET['id_produit'], PDO::PARAM_INT);
    $request->execute();

    if($request->rowCount())
    {
        $produit = $request->fetch(PDO::FETCH_ASSOC);
        // echo"<pre>"; print_r($produit); echo"</pre>";

        extract($produit);
    }
    else
    {
        header("location: boutique.php");
    }
}
else
{
    header("location: boutique.php");
}


require_once('include/header_inc.php');
require_once("include/nav_inc.php");
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

    <!-- Exo : afficher la liste des catégories stockées en BDD, chaque lien de catégorie renvoi vers la page boutique à la bonne catégorie -->


        <div class="fixed-top col-lg-3" style="top:8%; left:7%;">

        <?php $cat=$bdd->query("SELECT DISTINCT categorie FROM produit");?>

            <h1 class="my-4 text-center"><?= strtoupper($categorie) ?></h1>
            <div class="list-group text-center">
                <li class="list-group-item bg-dark text-white">CATÉGORIE</li>
                <?php while($nomCat = $cat->fetch(PDO::FETCH_ASSOC)) :
                    ///////////************* fetch() renvoie un seul array // fetchAll() renvoie un array multi *********///////////
                    // echo "<pre>"; print_r($nomCat); echo "</pre>";
                    ?>

                    <a href="boutique.php?categorie=<?= $nomCat['categorie'] ?>" style="text-decoration :none;" class='list-group-item text-center text-black'><?= $nomCat['categorie'] ?></a>


                <?php endwhile;?>
                
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9 mt-5" style="left:30%;">

            <div class="card mt-4">
                <img class="card-img-top img-fluid w-50 h-50" src="<?= $photo ?>" alt="">
                <div class="card-body">
                    <h3 class="card-title text-info"><?= ucfirst($titre) ?></h3>
                    <h4><?= $prix ?>€</h4>
                    <div class="col my-3">
                        <h5 class="h5 text-info">- Public : <?= $public ?></h5>
                        <h5 class="h5 text-info">- Couleur : <?= strtolower($couleur) ?></h5>
                        <h5 class="h5 text-info">- Taille : <?= $taille ?></h5>
                    </div>
                    <p class="card-text"><?= $description ?></p>

                    <!-- /////////////////////// AFFICHAGE DU STOCK PRODUIT //////////////////////////////// -->
                    <?php if($stock <= 10 && $stock != 0) : ?>

                        <p class="card-text text-danger font-italic">Attention, il ne reste que <?= $stock ?> exemplaire(s)</p>
                    <?php elseif($stock > 10) : ?>
                        <p class="card-text text-success font-italic">En stock</p>

                    <?php endif; ?>
                <hr>

                    <?php if($stock > 0) : ?>

                        <form action="panier.php" method="post" class="form-inline">
                            <!-- POUR RECUP L'ID LORS DU SUBMIT AU PANIER -->
                            <input type="hidden" id="id_produit" name="id_produit" value="<?= $id_produit ?>">

                            <div class="form-group">
                                <label for="quantite" class="mr-2">Quantité :</label>
                                <select class="form-control" name="quantite" id="quantite">
                                    <?php for($i=1; $i<= $stock && $i <= 30; $i++): ?>

                                        <option value="<?= $i?>"><?= $i?></option>

                                    <?php endfor; ?>
                                </select>
                            </div>
                            <input type="submit" name="ajout_panier" value="AJOUTER AU PANIER" class="shadow btn btn-success ml-2">
                        </form>

                    <?php else : ?>

                        <p class="card-text text-danger font-italic">Désolé, en rupture de stock</p>

                    <?php endif; ?>
                    <!-- /////////////////////// FIN AFFICHAGE DU STOCK PRODUIT //////////////////////////////// -->

                </div>
            </div>
                <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    AVIS CLIENT
                </div>
                <div class="card-body">
                    <p>J'adore cet article ❤ <br> Commandé il y a 1 mois maintenant, je suis très satisfait du service. La livraison est rapide et le colis bien emballé. Allez-y les yeux fermés, surtout à ce prix !!!</p>
                    <small class="text-muted">Posté par Pierre le 03/01/2017</small>
                    <hr>
<!--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>-->
<!--                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>-->
<!--                    <hr>-->
<!--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>-->
<!--                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>-->
<!--                    <hr>-->
<!--                    <a href="#" class="btn btn-success">Donnez votre avis !</a>-->
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->
</div>
<!-- /.container -->

<?php require_once("include/footer_inc.php"); ?>
