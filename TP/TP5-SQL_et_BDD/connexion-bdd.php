<?php

$connexion = new PDO('mysql:host=localhost;dbname=entreprise', 'root', '');

var_dump($connexion);

if(isset($_GET['action'])) {

    if($_GET['action'] === 'supprimer') {
        $delete_query = $connexion->query("DELETE FROM employes WHERE id_employes=$_GET[id];");
        $execute = $delete_query->execute();
        // var_dump($execute);
    }
}

# Créer une requête SQL pour vous insérer dans la table 'employes'
// $insert_query = $connexion->query("INSERT INTO employes VALUES (NULL, 'Jonathan', 'Gredler', 'm', 'informatique', '15/05/04', 2000)");


# Modifier votre salaire en ajoutant +100€
$update_query = $connexion->query("UPDATE employes SET salaire=salaire+100 WHERE id_employes=991;");



# Récupération de tous les employés de la table pour les afficher
$query = $connexion->query('SELECT * FROM employes;');
$employes = $query->fetchAll(PDO::FETCH_ASSOC);

var_dump($_GET);


?>




<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SQL et BDD</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

    <h1 class="text-center my-4">Affichage de toute la table SQL 'employes' avec PHP</h1>

    <div class="row">
        <div class="col-8 mx-auto my-4">

            <table class="table table-hover">
                <thead class="table-dark">
                    <tr class="text-center">
                      <th>#</th>
                      <th>Prénom</th>
                      <th>Nom</th>
                      <th>Civilité</th>
                      <th>Service</th>
                      <th>Embauché le:</th>
                      <th>Salaire</th>
                      <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($employes as $employe) : ?>
                        <tr class="text-center">
                            <td><?= $employe['id_employes'] ?></td>
                            <td><?= $employe['prenom'] ?></td>
                            <td><?= $employe['nom'] ?></td>
                            <td><?= $employe['civilite'] ?></td>
                            <td><?= $employe['service'] ?></td>
                            <td><?= $employe['date_embauche'] ?></td>
                            <td><?= $employe['salaire'] ?></td>
                            <td>
                                <a href="?action=supprimer&id=<?= $employe['id_employes'] ?>" class='text-danger' onclick="return confirm('Voulez-vous supprimer définitivement cet employé ?')"><i class="bi bi-x-circle-fill"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?> 
                </tbody>
            </table>

        </div>
    </div>

</body>
</html>