<?php 
require_once('include/init_inc.php');
require_once('include/header_inc.php');
require_once('include/nav_inc.php');
?>

<h1 class="display-1 text-center my-5">Félicitations</h1>

<h3 class="text-center">Votre commande est bien été prise en compte !</h3>

<h4 class="text-center"> Votre numéro de commande <span class="text-success">CMD<?= $_SESSION['num_cmd'] ?></span></h4>

<p class="text-center mt-5">
    <a href="profil.php" class="btn btn-success ">VOIR MES COMMANDES</a>
</p>



<?php require_once('include/footer_inc.php'); ?>