<?php 
require_once('include/init_inc.php');

// Lorque l'internaute clique sur le lien 'deconnexion', il transmet dans le même temps dans l'URL les paramètres 'action=deconnexion'
// La condition IF permet de vérifier si l'indice 'action' est bien définit dans l'URL et qu'il a pour valeur 'deconnexion', on entre dans le IF seulement dans le cas où l'internaute clique sur  'deconnexion'
// Pour que l'internaute soit déconnecté, il faut soit supprimer la session ou vider une partie afin que l'indice 'user' dans la session ne soit plus défini
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
    unset($_SESSION['membre']);
}

extract($_POST);

if(isConnect())
{
    header("location: profil.php");
}

if($_POST)
{
    $data= $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo OR email = :email");
    $data->bindValue(':pseudo', $email_pseudo, PDO::PARAM_STR);
    $data->bindValue(':email', $email_pseudo, PDO::PARAM_STR);
    $data->execute();

    if($data->rowCount())
    {
        // echo "Ce pseudo ou cet email existant en BDD";
        $user = $data->fetch(PDO::FETCH_ASSOC);
       // echo "<pre>"; print_r($user); echo "</pre>";

        // password_verify('la string du form', 'le mdp en bdd hashé') ===> compare une clé de hashage (le mdp en bdd) à une chaine de caractères (le mdp saisi dans le formulaire) 
        if (password_verify($password, $user['mdp']))
        {
           // echo "MDP ok";

           // On passe en revue toute les données de l'internaute recupérées en BDD de l'internaute qui a correctement remplit le forulaire de connexion
            // $user : tableau ARRAY contenant toute les données de l'utilisateur en BDD
           foreach($user as $key => $value)
           {
               if($key != 'mdp') // on exclut la clef 'mdp' de l'array 'membre' pour ne pas la stocker dans la session
               {
                   // sert à garder les infos du membre tout au long de sa session connectée sur le site, accessible partout dans le site

                   // On crée dans la session un indice 'user' contenant un tableau ARRAY avec toute les données de l'utilisateur
                    // C'est ce qui permettra d'identifier l'utilisateur connecté sur le site et cela lui permettra de naviguer sur le site tout en restant connecté
                   $_SESSION['membre'][$key] = $value;
               }

               header("location: profil.php");
           }
        }
        else
        {
            // echo "erreur MDP";
            $error = "<p class='text-center text-white bg-danger p-3 col-md-4 mx-auto'>Le mot de passe est invalide</p>";
        }
    } 
    else
    {
        // echo "erreur pseudo ou email";
        $error = "<p class='text-center text-white bg-danger p-3 col-md-4 mx-auto'>Le pseusdo ou l'email est invalide</p>";
    }
}




require_once('include/header_inc.php');
require_once("include/nav_inc.php");
?>

<h1 class="display-4 text-center my-4">Identifiez-vous</h1>

<?php if(isset($error)) echo $error; ?>

<form class="col-md-4 mx-auto my-5" method="POST">

    <div class="form-group">
        <label for="email_pseudo">Email / Pseudo</label>
        <input type="text" id="email_pseudo" name="email_pseudo" class="form-control" value="<?php if(isset($email_pseudo)) echo $email_pseudo; ?>">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" class="form-control">
    </div>
    <button type="submit" class="col-md-4 offset-md-4 btn btn-success">Connexion</button>
</form>

<?php 
require_once('include/footer_inc.php');
?>