<?php 
require_once('../include/init_inc.php');

if(!isAdminConnect())
{
    header('location:' . URL . 'connexion.php');
}

// echo "<pre>"; print_r($_GET); echo "</pre>";

///// EDITER UN MEMBRE /////

if (isset($_GET['action']) && $_GET['action'] == 'supp')
{
    $supp= $bdd->prepare("DELETE FROM membre WHERE id_membre = :id");
    $supp->bindValue(':id', $_GET['id_membre'], PDO::PARAM_INT);
    $supp->execute();


    $validSupp = "<p class='col-md-6 mx-auto my-3 py-1 text-center text-danger bg-dark border border-danger rounded h5'>La suppression de $_GET[pseudo] (ID $_GET[id_membre]) a bien été effectué.</p>";
}


///// EDITER UN MEMBRE /////

if (isset($_GET['action']) && $_GET['action'] == 'edit')
{
    if(isset($_GET['id_membre']) && !empty($_GET['id_membre']))
    {

        $query = $bdd->prepare('SELECT * FROM membre WHERE id_membre = :id');
        $query->bindValue(':id', $_GET["id_membre"], PDO::PARAM_INT);
        $query->execute();

        if($query->rowCount())
        {
            $edit = $query->fetch(PDO::FETCH_ASSOC);
            // echo "<pre>"; print_r($edit); echo "</pre>";
        }
        else
        {
            header('location:' . URL . 'admin/backOffice_membre.php');
        }   

        //extract($edit);
    }
    else
    {
        header('location:' . URL . 'admin/backOffice_membre.php');
    }

    // La boucle foreach() génère une $variable par tour de boucle
    // On se sert de la variable $key qui receptionne un indice du array $edit(le fetch de $query) par tour de boucle pour créer une variable ($$key => receptionne le nom de l'indice ex: 1er tour $$key=$id_membre et ainsi de suite) 
    foreach($edit as $key => $value)
    {
        $$key = (isset($edit[$key])) ? $edit[$key] : ''; // $$key est semblable à un extract($edit) = + condition ternaire
    }

    // REQUETE DE MODIFICATION MEMBRE
    if($_POST)
        {
            // echo "<pre>"; print_r($_POST); echo "</pre>";

            extract($_POST);

            $update= $bdd->prepare('UPDATE membre SET nom = :nom, prenom = :prenom, civilite = :civilite, ville = :ville, code_postal = :cp, adresse = :adresse, statut = :statut WHERE id_membre = :id');
            // J'ai extract($_POST) donc je peux ecrire ses indinces comme une $variable ;)
            $update->bindValue(':nom', $nom, PDO::PARAM_STR);
            $update->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $update->bindValue(':civilite', $civilite, PDO::PARAM_STR);
            $update->bindValue(':ville', $ville, PDO::PARAM_STR);
            $update->bindValue(':cp', $code_postal, PDO::PARAM_INT);
            $update->bindValue(':adresse', $adresse, PDO::PARAM_STR);
            $update->bindValue(':statut', $statut, PDO::PARAM_INT);
            $update->bindValue(':id', $_GET['id_membre'], PDO::PARAM_INT);

            $update->execute();

            $validEdit = "<span class='col-md-5 d-block mx-auto my-3 py-1 text-center text-danger bg-info rounded h5'>La modification de $pseudo (ID $_GET[id_membre]) a bien été effectué.</span>";

            // on redirige l'admin vers la page de gestion membre après le submit du formulaire de modification en 'vidant' l'url
            $_GET = "";
        }

}

// AFFICHAGE DES MEMBRES EN BDD
$select = $bdd->query("SELECT id_membre AS ID, pseudo, nom, prenom, email, civilite, ville, code_postal AS CP, adresse, statut FROM membre");

// AFFICHAGE DU NOMBRE D'ADMIN
$nbreAdmin = $bdd->query("SELECT COUNT(statut) AS statut FROM membre WHERE statut = 1");
$admin= $nbreAdmin->fetch(PDO::FETCH_ASSOC);
// echo "<pre>"; print_r($admin); echo "</pre>";


require_once('../include/header_inc.php');
require_once('../include/nav_inc.php');
?>

<!-- ///////////////////////////// TABLE DES MEMBRES /////////////////////////////// -->
<h1 class="mx-auto my-5 text-center display-4">Gestion des Membres</h1>

<!-- AFFICHAGE DES MESSAGE DE VALIDATION D'ACTION -->
<?php if(isset($validSupp)) echo $validSupp;
if(isset($validEdit)) echo $validEdit;
?>

<div>
    <p>Nombre de MEMBRES : <span class="text-center badge badge-success"><?=$admin['statut']?></span></p>
    <p>Nombre d'ADMIN : <span class="text-center badge badge-info"><?=$admin['statut']?></span></p>
</div>
<table class="col-md-10 text-center mx-auto border table-bordered">

    <tr>
        <?php 

            for($i =0; $i < $select->columnCount(); $i++)
            {
                $nomColonne = $select->getColumnMeta($i);
                echo  "<th>" . strtoupper($nomColonne['name']) . "</th>";
            }
        ?>
            <th class="text-info">EDIT</th>
            <th class="text-danger">SUPP</th>
    </tr>

    <?php while($membre=$select->fetch(PDO::FETCH_ASSOC)) : ?>

        <tr>
            <?php
            foreach($membre as $key => $value)
            {
                if($key == 'statut')
                {
                    if($value == 0)
                    {
                        echo "<td>MEMBRE</td>";
                    }
                    else
                    {
                        echo "<td class='bg-info text-white'>ADMIN</td>";
                    }
                }
                else
                {
                echo "<td>" . $value . "</td>";
                }
            }
            
            ?>

        <td><a href="?action=edit&id_membre=<?=$membre['ID'] ?>" class="btn"><i class='fas fa-edit text-info'></i></a></td>
        <td><a href="?action=supp&id_membre=<?= $membre['ID'] ?>&pseudo=<?=$membre['pseudo']?>" class="btn" onclick="return confirm('Supprimer le membre ?');"><i class='fas fa-trash-alt text-danger'></i></a></td>
        
        </tr>

    <?php endwhile; ?>

</table>

<!-- ///////////////////////////// FORMULAIRE DE MODIFICATION /////////////////////////////// -->

<?php if(isset($_GET['action']) && $_GET['action'] == 'edit') : ?>

<form action="" method="POST" class="col-md-6 mx-auto my-5">

<h3 class="text-center text-white my-4 bg-info rounded mx-auto col-md-7">MODIFIER MEMBRE</h3>

    <div class="form-group">
        <label for="pseudo" class="text-muted">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" value="<?= $pseudo ?>" class="form-control bg-light border border-dark text-muted" disabled>
    </div>
    
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom" value="<?= $nom ?>" class="form-control bg-light border border-info text-info">
        </div>

        <div class="form-group col-md-4">
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="prenom" value="<?= $prenom ?>" class="form-control bg-light border border-info text-info">
        </div>

        <div class="form-group col-md-4">
            <label for="email" class="text-muted">Email</label>
            <input type="text" name="email" id="email" value="<?= $email ?>" class="form-control bg-light border border-dark text-muted" disabled>
        </div>
    </div>

    <div class="form-group">
        <label for="civilite">Civilite</label>
        <input type="text" name="civilite" id="civilite" value="<?= $civilite ?>" class="form-control bg-light border border-info text-info">
        <small class="text-danger ml-2">OBLIGATOIRE : homme ou femme</small>

    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="ville">Ville</label>
            <input type="text" name="ville" id="ville" value="<?= $ville?>" class="form-control bg-light border border-info text-info">
        </div>

        <div class="form-group col-md-4">
            <label for="cp">Code postal</label>
            <input type="text" name="cp" id="cp" value="<?= $code_postal?>" class="form-control bg-light border border-info text-info">
        </div>

        <div class="form-group col-md-4">
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" id="adresse" value="<?= $adresse ?>" class="form-control bg-light border border-info text-info">
        </div>
    </div>
    <div class="form-group">
        <label for="statut">Statut</label>
        <input type="text" name="statut" id="statut" value="<?= $statut?>" class="form-control col-md-4 bg-light border border-info text-info">
        <small class="text-danger ml-2">OBLIGATOIRE : 0 ou 1 (1 = admin)</small>
    </div>

    <button type="submit" class="col-md-4 offset-md-4 mb-5 btn btn-success">MODIFIER</button>

</form>

<?php endif; ?>


<?php 
require_once('../include/footer_inc.php');
?>