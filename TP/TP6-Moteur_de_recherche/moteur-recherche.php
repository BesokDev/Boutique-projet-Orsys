<?php 

$connexion = new PDO('mysql:host=localhost;dbname=entreprise', 'root', '');

if(isset($_GET['search_query']) && !empty($_GET['search_query'])) {

    # Cette fonction native extract() permet d'extraire les clés d'un array sous forme de variable
    # ex: $_GET['search_query] => $search_query
    extract($_GET);

    $requete = $connexion->query("SELECT * FROM employes WHERE
        prenom LIKE '%$search_query%' OR
        nom LIKE '%$search_query%' OR
        service LIKE '%$search_query%'
        ORDER BY date_embauche DESC;"
    );

    // var_dump($requete);

    # Si l'exécution de la requête se passe bien, on récupère tous les résultats
    if($requete->execute() !== false ){
        $resultat_employes = $requete->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($resultat_employes); 
    }
}

?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-primary fw-bolder" aria-current="page" href="moteur-recherche.php">ACCUEIL</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<h1 class="text-center my-4">Bienvenue dans le moteur de recherche</h1>

<div class="row">
    <div class="col-6 mx-auto mb-5">
        <form method="get" action="moteur-recherche.php" class="d-flex">
            <input class="form-control me-2"
                   type="search"
                   name="search_query"
                   placeholder="Rechercher par prénom, nom ou service"
                   aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Rechercher</button>
        </form>
    </div>
</div>


<?php if(isset($_GET['search_query'])) : ?>

    <?php if(isset($resultat_employes) && !empty($resultat_employes)) : ?>

        <div class="row d-flex ms-3">

            <?php foreach($resultat_employes as $employe) : ?>

                <div class="col-2 mb-4">
                    <div class="card" style="width: 14.5rem;">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">
                            <h5 class="card-title">Fiche employé n° <?= $employe['id_employes'] ?></h5>
                            <p class="card-text"><?= $employe['prenom'] . ' ' . $employe['nom'] ?>, 
                            <?= $employe['civilite'] === 'm' ? 'homme' : 'femme' ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Service : <?= $employe['service'] ?></li>
                            <li class="list-group-item">Embauché le : <?= $employe['date_embauche'] ?></li>
                            <li class="list-group-item">Salaire : <?= $employe['salaire'] ?></li>
                        </ul>
                        <!-- <div class="card-body">
                            <a href="#" class="card-link">Card link</a>
                        </div> -->
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    <?php else : ?>

        <div class="row">
            <h2 class="alert alert-warning text-center my-4">La recherche n'a rien retourné.</h2>
        </div>

    <?php endif; ?>

<?php endif; ?>

</body>
</html>