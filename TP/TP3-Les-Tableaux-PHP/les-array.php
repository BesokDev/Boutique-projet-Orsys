<?php

include_once '../include/_fonctions-TP2.php';

h2Generator("Les tableaux / array");

/*
 Un array, ou tableau, est un type de variable qui contient plusieurs valeurs.
Ces valeurs sont organisées sous forme de paire "key => value".
Lorsque vous n'avez que des valeurs, les clefs sont indexées numériquement à partir de 0.
    -----------------------------------------
    |   0   |   1   |   2   |   3   |   4   |
    -----------------------------------------
    |  Léna |  Mina | Toto  | Fred  |  Melo |
    -----------------------------------------

 */

 # Déclaration et affectation d'un array
 $prenoms = ["Léna", 'Mina', 'Toto', "Fred", "Mélo"];

 # Affichage d'un index
echo $prenoms[2];

# vous pouvez assigner une nouvelle valeur à un tableau comme suit :
$prenoms[] = "Jonathan";
// array_push($prenoms, "Titi");
var_dump($prenoms);


//////////////////////////// les fonction natives pour les array /////////////////
# Vérifions si la valeur "Titi" existe dans le tableau $prenoms
var_dump(in_array('Toto', $prenoms));
echo count($prenoms);

echo '<br>';
$pseudo = 'Besok';
echo strlen($pseudo);

echo '<br>';
# Confidence : en PHP, les string sont en fait des array.
echo $pseudo[2];

separator();
h2Generator("Les Array Associatifs (ou array multi-dimensionnels)");

$personnes = [
    # 1er élément
    'Léna' => [
        'age' => 35,
        'sport' => null,
        'civilité' => 'femme',
        'ville' => 'Paris',
        'permis_conduire' => false
    ],
    # 2eme élément
    'Mina' => [
        'age' => 28,
        'sport' => 'natation',
        'civilité' => 'femme',
        'ville' => 'Belgrade',
        'permis_conduire' => true
    ],
    'Jonathan' => [
        'age' => 36,
        'sport' => 'Tennis',
        'civilité' => 'homme',
        'ville' => 'Bergerac',
        'permis_conduire' => true
    ],
];

# Afficher l'age de Mina.
# Afficher le sport de Léna.
# Si votre âge est supérieur à 18 ans, alors on affiche "Vous êtes majeur", sinon "Vous êtes mineur".
echo $personnes['Mina']['age'];
echo $personnes['Léna']['sport']; // valeur null donc aucun affichage

if($personnes['Jonathan']['age'] > 18) {
    echo "Vous êtes majeur !"; 
}
else {
    echo 'Vous êtes mineur';
}


?>