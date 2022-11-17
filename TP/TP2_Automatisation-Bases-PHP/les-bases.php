<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h1>Découverte de PHP</h1>
<br>
<h2>La balise php et le mot-clé 'echo'</h2>
<!-- Tout d'abord, nous pouvons écrire du code HTML dans un fichier PHP -->
<!-- L'inverse n'est pas possible -->

<?php // la balide ouvrante PHP

    /*
    echo est une instruction (un keyword) qui nous permet d'afficher un message sur le navigateur.
    Une instruction se termine TOUJOURS par un point virgule.    
    */
    echo "Bonjour"; 

    // Nous pouvons aussi afficher une balise HTML.
    echo "<p>Je suis un paragraphe HTML avec un 'echo'</p>"; 
    
?> <!-- Balise fermante PHP -->

<h2>La balise PHP raccourcie</h2>

<?= "Je suis une balise PHP raccourcie qui effectue un 'echo' en même temps"; ?>

<h2>Les variables en PHP : Types / Déclaration / Affectation</h2>

<?php

$a = 'string'; // type string
$b = 125; // type integer
$c = 12.5; // type float
$d = true; // bool
$e = null;// type null
$f = ['jaune', 'vert', 'noir'];  // type array (tableau)

echo $a;
echo "<br>";
echo $b;
echo "<br>";
echo $c;
echo "<br>";
echo $d;
echo "<br>";
echo $e;
echo "<br>";
echo $f[1];
echo "<br>";

 /*
     Les différents types de variables qui existent en PHP :

    1- type string => ce type de variable est une chaîne de caractères. On la déclare avec des 'simple quotes' ou 'double quotes'.
    2- type integer (int/float/double) => ce type de variable contient uniquement des valeurs numériques.
        => cela peut être des nombres entiers (int), des nombres décimaux (float), des TRÈS grands nombres (double).
    3- type boolean (bool) => ce type de variable est particulier, car il ne peut avoir que deux valeurs : true ou false.
    4- type array => ce type de variable est comme une super variable, elle peut contenir plusieurs valeurs, et de tout types !
        => on la déclare avec des crochets [] : $prenoms = ['jojo', 'toto', 'juju'] => On sépare les différentes valeurs avec des virgules.
    5- type null => ce type de variable est spécial, il représente l'absence de valeur.

    ---------------------------- TYPES SPÉCIAUX -------------------------------
    6- type object => ce type de variable est utilisé dans le paradigme orienté objet. Un objet se repère aux accolades et le keyword 'class'
    7- type resource => ce type de variable représente une ressource, c'est-à-dire un fichier le plus souvent streamé.
     */
?>

<hr><br>
<h2>La concaténation en PHP</h2>

<?php 

// La concaténation permet d'accrocher plusieurs valeurs les unes à la suite des autres.
// Elle s'effectue avec un point entre les éléments à concaténer.

$prenom = "Jonathan";
$nom = 'Gredler';

// Les simples quotes ne permettent pas d'évaluer les variables
echo '<p>Bonjour '. $prenom . ' ' . $nom .'</p>';

// Les doubles quotes, quant à elles, permettent d'évaluer les variables.
echo "<p>Bonjour $prenom $nom</p>";

// Exemple :
echo '$prenom';
echo '<br>';
echo "$prenom";

?>

<br><hr>
<h2>Les CONSTANTES en PHP</h2>

<?php

/* Par convention, les constantes se déclarent toujours en ALL_CAPS, à la différence des variables.
---------------------------------------------------------------------------------------------------
*/

echo "<h3>Les constantes magiques</h3>";

echo "Il y a une constante magique pour demander le chemin absolu d'un fichier : ". __FILE__;
echo '<br>';
echo "Il y a une constante magique pour demander le chemin vers le dossier courant : " . __DIR__ ;
echo '<br>';
echo "Il y a une constante magique pour demander le numéro de ligne du code courant : " . __LINE__ ;

// Les constantes magiques en PHP commencent toujours par 2 underscores et se terminent avec 2 underscores.

echo "<h3>Les constantes utilisateur</h3>";

define("PRENOM", "Jonathan");

echo PRENOM;

// define("PRENOM", "jojo"); On ne pourra pas rédéfinir une constante déjà définie. Cela affiche un warning.
?>

<br><hr>
<h2>Les opérateurs arithmétiques</h2>

<?php 

$chiffre1 = 10;
$chiffre2 = 5;

echo "Addition : " . ($chiffre1 + $chiffre2);
echo '<br>';
echo "Soustraction : " . ($chiffre1 - $chiffre2);
echo '<br>';
echo "Multiplication : " . ($chiffre1 * $chiffre2);
echo '<br>';
echo "division : " . ($chiffre1 / $chiffre2);

echo "<h3>Incrémentation</h3>";

echo 'J\'incrémente ma variable $chiffre1 (vaut 10) de 1 : ' . ++$chiffre1;
?>

<hr><br>
<h2>Structure Conditionnelle : if/elseif/else</h2>

<?php

$var1 = 'test';
$var2 = '';

echo"<h3>Test empty()</h3><br>";

if(empty($var1)) {
    echo 'je suis dans le if';
} elseif (empty($var2)) {
    echo 'je suis dans le elseif';
} else {
    echo 'Aucune condition respectée';
}

echo"<h3>Test isset()</h3><br>";

if(isset($var1)) {
    echo 'je suis dans le if';
} elseif (isset($var2)) {
    echo 'je suis dans le elseif';
} else {
    echo 'Aucune condition respectée';
}

echo"<h3>Les opérateur de comparaison</h3><br>";

/*
        OPÉRATEURS DE COMPARAISON

        == : double égal pour comparer la valeur
        === : triple égal pour comparer la valeur ET le type (comparaison stricte)
        < : inférieur à
        > : supérieur à
        <=: inférieur ou égal à
        >=: supérieur ou égal à
        != : différent de (! =)
        !== : strictement différent de (! = =)

        OPÉRATEURS LOGIQUES

         && : double esperluette AND (ET)
        || : double pipe OR (OU)
     */

    $x = 2;
    $y = 5;
    $z = 8;

    if($x > $y) {
        echo '$x est bien supérieur à $y';
    } elseif ($x < $y) {
        echo '$x est bien inférieur à $y';
    } else {
        echo '$x est égal à $y';
    }

    echo '<br>';

    if($z === $y && $x < $z) {
        echo '$z est bien égal à $y ET $x est inférieur à $z';
    } 

    echo '<br>';
    
    if($y > $x || $z === $x) {
        echo '$y est supérieur à $x OU $z est strictement égal à $x';
    }

    echo '<br>';

    if($x !== $y) {
        echo '$x est strictement différent en type et valeur de $y';
    } else {
        echo 'les deux valeurs sont égales';
    }
?>

<br><hr>
<h2>Les SUPERGLOBALES</h2>

<?php

    var_dump($_GET);
    var_dump($_POST);
    var_dump($_SERVER);
    var_dump($_FILES);
    var_dump($_SESSION);
    var_dump($_COOKIE);
    var_dump($_REQUEST);
    var_dump($_ENV);

?>

<hr><br>

<h2>Les fonctions prédéfinies de PHP</h2>

<?php

    echo date('d/m/Y - H:i:s');
    echo '<br>';

    $email = 'toto@toto.fr';

    echo strlen($email);
    echo '<br>';
    echo is_numeric($email);
    echo '<br>';
    echo strpos($email, '@');
    echo '<br>';
    echo strtoupper($nom);
    echo '<br>';

    echo "<h3>Les fonctions utilisateur ou fonctions nommées</h3>";
    echo '<br>';

    # Déclaration de fonction utilisateur sans paramètre
    function separator() 
    {
        echo "<br><hr><br>";
    }

    # Appel de fonction
    separator();

    # EXERCICE : Créer une fonction qui affiche "Bonjour"
    function sayHello() 
    {
        echo "Bonjour<br>";
    }

    sayHello();

    function sayHello2($name) 
    {
        echo "Bonjour " . $name; 
    }

    sayHello2($prenom);

    echo "<br>";

    # EXERCICE : Créer une fonction qui additionne 2 chiffres.
    function add($num1, $num2) {
        # Il ne pourra jamais y avoir de code après le mot-clé "return" !!
        return $num1 + $num2;
    }
    $resultat = add(1,2);
    echo "Le résultat de l'addition est : $resultat";
    echo "<br>";

    # Déclaration de la fonction, qui prend un paramètre en entrée
    function prixHTtoPrixTTC($prixHT) {
        return $prixHT * 1.2 ; // Valeur de retour, c'est le calcul de l'opération
    }

    $montantTTC = prixHTtoPrixTTC(100);

    echo $montantTTC;
    echo "<br>";


    function createTitle($titre) {
        separator();
        echo "<h2>$titre</h2>";
    }

    createTitle("Les Boucles");

    /*

    En programmation il ya une notion de répétition de code. On appelle cela l'itération.
    Ce mécanisme se fait à travers des "boucles itératives" (loops)
    En PHP il existe plusieurs boucles, nous verro ns les 3 principales :

        - for
        - foreach
        - while
    */

    echo "<h3>Boucle For</h3>";

    /*  
    La boucle for attend 3 instructions :
        => 1ere : déclaration et affectation d'une variable $i
        => 2eme : une condition pour stopper la boucle, pour sortir de la boucle.
        => 3eme: incrémentation de la variable $i pour éviter une boucle infinie.
    */

    for ($i = 0; $i <= 10; $i++) {
        echo $i . "<br>";
    }

    # Répétez 5x un titre h4 avec le numéro de tour de boucle.
    for ($i=1; $i <=5; $i++) {
            echo "<h4>Tour n° : $i</h4>";
    }

    echo "<h3>Boucle While</h3>";

    /*
    La boucle while s'utilise différement d'une boucle for+
    Cependant, la logique est la même, on devra renseigner les mêmes instructions.
    */

    $j = 0;
    while ($j < 10) {
        echo "$j <br>";
        $j++;
    }

    echo "<h3>Boucle Foreach</h3>";

    # La boucle foreach() est utilisée pour parcourir un tableau (array).

    $tableau = ['Franck', 'Julie', 'Thomas', 'Lila'];

    foreach($tableau as $key => $prenom) {
        echo "Tout n° $key :" . $prenom. "<br>";
    }

    


?>
</body>
</html>