<!-- # EXERCICE : 
    1 - Créer un formulaire HTML avec un input text pour le prénom.
    2 - On souhaitera la méthode GET pour transmettre les données.
    3 - Dans un code PHP, afficher la valeur de l'input à l'aide de la superglobale appropriée.
    4 - Ajouter un input de type password avec son label.
    5 - Variabiliser la valeur de l'input. -->
<?php 

# Condition qui nous permet d'exécuter le code uniquement si le formulaire est soumis.
if($_POST) {

    // var_dump($_POST); 
    
    # Variabilisation de la valeur de l'input prenom.
    $prenom = $_POST['prenom'];
    // echo $prenom;

    echo '<br>';

    #Variabilisation de la valeur de l'input password.
    $passwordHash = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    // echo $passwordHash;

    $isPasswordOk = password_verify($_POST['mdp'], $passwordHash);
    // var_dump($isPasswordOk);

    var_dump($_FILES);

    $from = $_FILES['photo']['tmp_name'];

    $dossierProjet = $_SERVER["DOCUMENT_ROOT"];
    $dossierUploads = "/TP/TP3-Formulaire-simple/uploads/";    
    $nomPhoto = str_replace(' ', '-', $_FILES['photo']['name']);

    // var_dump($nomPhoto); die

    $to = $dossierProjet . $dossierUploads . $nomPhoto;

    move_uploaded_file($from, $to);
}


?>



    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Les formulaires simples</title>
    </head>
    <body>
        
    <form action="#" method="post" enctype="multipart/form-data">

        <label for="prenom">Quel est votre prénom ?</label>
        <input type="text" name="prenom" id="prenom">

        <br>

        <label for="mdp">Choisissez un mot de passe</label>
        <input type="password" name="mdp" id="mdp">

        <br>

        <label for="photo">Photo de profil</label>
        <input type="file" name="photo" id="photo">

        <br>

        <input type="submit" value="Valider">

    </form>


    </body>
    </html>
