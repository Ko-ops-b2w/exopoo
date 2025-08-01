<?php

class Chien {

    private $race;
    private $nom;

    public function __construct($race, $nom) {
        $this->race = $race;
        $this->nom = $nom;
    }

    public function getRace() {
        return $this->race;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setRace($race) {
        $this->race = $race;
    }

    public function setNom($nom) {
        $this->nom = $nom; // ✅ correction ici
    }

    public function aboyer() {
        echo "Woof! Je suis {$this->nom}\n";
    }
}

// ✅ Ce qui suit est en dehors de la classe :

$chien1 = new Chien("Berger Allemand", "Rex");

echo "Nom : " . $chien1->getNom() . "<br>";
echo "Race : " . $chien1->getRace() . "<br>";

$chien1->setNom("Max");

$chien1->aboyer();

?>
