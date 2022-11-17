<?php

require_once('include/init_inc.php');

if(isConnect())
{
    header("location: profil.php");
}

// 2. Contrôler en PHP que l'on réceptionne bien toute les données saisies dans le formulaire

// echo "<pre>"; print_r($_POST); echo "</pre>";

extract($_POST);

if($_POST && !empty($_POST))
{
    // class bootstrap : bordure rouge
    $border="border border-danger";

    // 3. Contrôler la validité du pseudo, si le pseudo est existant en BDD, alors on affiche un message d'erreur. Faites de même pour le champ 'email'
    $verifPseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verifPseudo->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $verifPseudo->execute();

    if (empty($pseudo))
    {
        $errorPseudo= "<p class='text-danger font-italic'>Il vous faut un pseuso</p>";
        $error=true;
    }

    if ($verifPseudo->rowCount())
    {
        $errorPseudo= "<p class='text-danger font-italic'>Dommage, le pseudo $pseudo est déjà pris. Veuillez en saisir un autre.</p>";
        $error = true;
    }

    $verifEmail = $bdd->prepare("SELECT * FROM membre WHERE email = :email");
    $verifEmail->bindValue(':email', $email, PDO::PARAM_STR);
    $verifEmail->execute();

    if($verifEmail->rowCount())
    {
        $errorEmail= "<p class='text-danger font-italic'>Un compte existe déjà avec cet email : $email. Veuillez en saisir un autre.</p>";
        $error = true;
    }

    if (empty($email))
    {
        $errorEmail= "<p class='text-danger font-italic'>Il faut renseigner un email</p>";
        $error=true;
    }

// 4. Informer l'internaute si les mots de passe ne correspondent pas.
    if($mdp != $confirm_mdp)
    {
        $errorMdp = "<p class='text-danger font-italic'>Attention ! Les mots de passe ne sont pas identiques</p>";
        $error = true;
    }

    if(!isset($error))
    {
        // 5. Gérer les failles XSS
        foreach($_POST as $key => $value)
        {
            $_POST[$key] = htmlspecialchars($value);
        }

        // CRYPTAGE DU MDP EN BDD
        $mdp = password_hash($mdp, PASSWORD_BCRYPT);


        // 6. SI l'internaute a correctement remplit le formulaire, réaliser le traitement PHP + SQL permettant d'insérer le membre en BDD (requete préparée | prepare() + bindValue())
        $insert=$bdd->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :sexe, :ville, :cp, :adresse)");

        $insert->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $insert->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $insert->bindValue(':nom', $nom, PDO::PARAM_STR);
        $insert->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $insert->bindValue(':email', $email, PDO::PARAM_STR);
        $insert->bindValue(':sexe', $sexe, PDO::PARAM_STR);
        $insert->bindValue(':adresse', $adresse, PDO::PARAM_STR);
        $insert->bindValue(':ville', $ville, PDO::PARAM_STR);
        $insert->bindValue(':cp', $cp, PDO::PARAM_INT);

        $insert->execute();

        // Après l'insertion en BDD, on redirige le user vers une page de confirmation d'inscription.
        header("location: valid_inscription.php");
    }

}

require_once('include/header_inc.php');
require_once('include/nav_inc.php');

?>

<!-- 
    Exo : 
1. Réaliser un formulaire d'inscription correspondant à la table 'membre' de la BDD 'boutique' (sauf id_membre et statut) et ajouter le champ 'confirmer mot de passe' (name="confirm_mdp")

2. Contrôler en PHP que l'on receptionne bien toute les données saisies dans le formulaire 

3. Contrôler la validité du pseudo, si le pseudo est existant en BDD, alors on affiche un message d'erreur. Faites de même pour le champ 'email'

4. Informer l'internaute si les mots de passe ne correspondent pas.

5. Gérer les failles XSS

6. SI l'internaute a correctement remplit le formulaire, réaliser le traitement PHP + SQL permettant d'insérer le membre en BDD (requete préparée | prepare() + bindValue())

 -->

<!-- Nous sommes entre la balise ouvrante <main> ... -->
<form class="col-md-6 mx-auto my-5" method="POST" >

    <h3 class="text-center text-white my-4 bg-dark rounded mx-auto col-md-8">1 - Vos Identifiants</h3>

    <div class="form-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" id="pseudo" name="pseudo" class="form-control <?php if(isset($errorPseudo)) echo $border; ?>">
        <?php if(isset($errorPseudo)) echo $errorPseudo; ?>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" class="form-control">
            
        </div>
        <div class="form-group col-md-6">
            <label for="confirm_mdp">Confirmer mot de passe</label>
            <input type="password" id="confirm_mdp" name="confirm_mdp" class="form-control">
            <?php if(isset($errorMdp)) echo $errorMdp; ?>
        </div>
    </div>

    <h3 class="text-center text-white my-4 bg-dark rounded mx-auto col-md-8">2 - Votre Civilité</h3>

    <div class="form-row mt-2">
        <div class="form-group col-md-6">
            <label for="prenom">Prenom</label>
            <input type="text" id="prenom" name="prenom" class="form-control">
        </div>
        <div class="form-group col-md-6">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control">
        </div>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <label for="sexe" class="input-group-text">Civilité</label>
        </div>
        <select name="sexe" id="sexe" class="custom-select">
            <option value="homme" selected>Homme</option>
            <option value="femme">Femme</option>
        </select>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control <?php if(isset($errorEmail)) echo $border; ?>">
        <?php if(isset($errorEmail)) echo $errorEmail; ?>
    </div>
    
    <h3 class="text-center text-white my-4 bg-dark rounded mx-auto col-md-8">3 - Votre Localité</h3>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville" class="form-control">
        </div>
        <div class="form-group col-md-4">
            <label for="cp">Code Postal</label>
            <input type="text" id="cp" name="cp" class="form-control">
        </div>
    </div>
    <div class="mt-4">
        <button type="submit" class="col-md-4 offset-md-4 btn btn-success">Validez</button>
    </div>
</form>






<!-- ... et la balise fermante </main> -->
<?php
require_once('include/footer_inc.php');
?>