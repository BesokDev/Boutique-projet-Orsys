<?php 
require_once('include/init_inc.php');
require_once('include/header_inc.php');
require_once("include/nav_inc.php");

if(!isConnect())
{
    header("location: connexion.php");
}

// echo "<pre>"; print_r($_SESSION); echo "</pre>";

extract($_SESSION['membre']);

// $user_data="";
// foreach($_SESSION['membre'] as $key => $value)
// {
//     $user_data .= "<p>$key : $value </p>";
// }



?>

<h2 class="display-4 mx-auto text-center text-black mt-5">Bonjour <span class='text-info'><?= $prenom;?></span></h2>

<!-- <?=$user_data; ?> -->
<div class="row">
    <div class="col-8 card mx-auto my-3 shadow-lg">
  <div class="card-body">

    <h5 class="card-title text-center">Vos infos personnelles</h5><hr>

    <?php foreach($_SESSION['membre'] as $key => $value) : ?>

        <?php if($key !== 'id_membre' && $key !== 'statut') : ?>

            <p class="card-text"><strong><?= $key ?></strong> : <?= $value ?></p>

        <?php endif; ?>
        
    <?php endforeach; ?> 

    <a href="#" class="card-link">Modifier</a>
  </div>
</div>
</div>
<?php 
require_once('include/footer_inc.php');
?>