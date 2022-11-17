<?php

// Si une recherche a été lancée


?>

<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="<?= URL ?>index.php" style="color:darkorange;">La Boutique !</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span></button>

    <div class="collapse navbar-collapse" id="navbarsExample04">

        <ul class="navbar-nav mr-auto">

            <?php if(isConnect()): // si le membre est connecté, mais NON ADMIN ?>

                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>profil.php">Mon compte</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>boutique.php">Boutique</a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>panier.php">Mon panier <span class="badge badge-info rounded-circle"><?= nbreProduitPanier(); ?></span></a>
                </li>

            <?php else: // acces visiteur non connecté ?>

                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>inscription.php">Créer votre compte</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>connexion.php">Connectez-vous</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>boutique.php">Boutique</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?= URL ?>panier.php">Mon panier</a>
                </li>

            <?php endif; ?>

            <?php if(isAdminConnect()): // acces ADMIN connecté (si statut_membre est 1)?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true">BACK OFFICE</a>

                    <div class="dropdown-menu" aria-labelledby="dropdown04">
                        <a class="dropdown-item" href="<?= URL ?>admin/backOffice_boutique.php">Gestion boutique</a>
                        <a class="dropdown-item" href="<?= URL ?>admin/backOffice_commande.php">Gestion commande</a>
                        <a class="dropdown-item" href="<?= URL ?>admin/backOffice_membre.php">Gestion membre</a>
                    </div>
                </li>

            <?php endif; ?>
        </ul>

        <?php if(isConnect()): // si le membre est connecté, mais NON ADMIN ?>
            <ul class="navbar-nav">
                <li class="nav-item active mr-4">
                    <a class="nav-link btn-sm btn-warning text-dark" href="<?= URL ?>connexion.php?action=deconnexion">Déconnection <i class="bi bi-box-arrow-right"></i></a>
                </li>
            </ul>
        <?php endif; ?>

        <form class="form-inline my-2 my-md-0" action="<?= URL ?>resultat_recherche.php" method="get">
            <input class="form-control" type="text" name="search_query" placeholder="Rechercher" title="Taper 'Entrée' pour lancer la recherche">
        </form>
    </div>
</nav>

<!-- //////////////////////////////// MAIN //////////////////////////////// -->

<main class="container-fluid">