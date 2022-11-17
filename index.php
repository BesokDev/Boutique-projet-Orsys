<?php 
require_once('include/init_inc.php');
require_once('include/header_inc.php');
require_once('include/nav_inc.php');
?>

<h1 class="text-center mx-auto mt-3">ACCUEIL</h1>

<div class="col-lg-9 mt-5 mx-auto">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block img-fluid mx-auto" src="<?= URL?>photo/slider1.png" alt="How to pay on internet">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid mx-auto" src="<?= URL?>photo/slider2.jpg" alt="How to improve your e-commerce">
            </div>
            <div class="carousel-item">
                <img class="d-block img-fluid mx-auto" src="<?= URL?>photo/slider3.jpg" alt="Are you happy, opinion less or sad about your experience ?">
            </div>
        </div>
    <!-- ///////////// CONTROLS PREV & NEXT /////////////// -->
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<?php require_once('include/footer_inc.php'); ?>