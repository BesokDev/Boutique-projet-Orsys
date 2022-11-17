<?php
class Voiture 
{
    const CAPACITE = 80;

    # PROPRIETE (props)
    public string $marque;
    public string $modele;
    public string $couleur;
    private int $puissance = 50;
    public bool $isElectric;
    private int $vitesse = 0 ;
    private int $reservoir = 0;
    private bool $isDemarrer = false;


    public function demarrer(): string
    {
        if($this->reservoir > 0) {
            $this->isDemarrer = true;
            return "La voiture est démarrée";
        }

        return "La voiture n'a pas assez d'essence pour démarrer";
    }

    public function remplirReservoir() 
    {
       return $this->reservoir = $this::CAPACITE;
    }

    public function rouler() 
    {
        if($this->isDemarrer) {
            return "Vous avancez dans votre belle voiture";
        }
        else {
            return "Vous devez démarrer la voiture pour rouler";
        }
    } # end function rouler()
    
} # end class

$voiture = new Voiture();
var_dump($voiture); 

$voiture->marque = "Ford";
$voiture->modele = "Focus";
$voiture->couleur = "vert";
$voiture->isElectric = false;

var_dump($voiture); 

$voiture2 = new Voiture();
$voiture2->marque = "Renault";
$voiture2->modele = "Clio";
$voiture2->couleur = "bleu";
$voiture2->isElectric = true;

var_dump($voiture2); 

$voiture->remplirReservoir();
echo $voiture->demarrer();
echo '<br>';
echo $voiture->rouler();



