<?php

// Classe parent : Humain
class Humain {
    // propriétés
    protected $nom;

    // constructeur
    public function __construct($nom) {
        $this->nom = $nom;
    }

    // getter pour le nom
    public function getNom() {
        return $this->nom;
    }

    // setter pour le nom
    public function setNom($nom) {
        $this->nom = $nom;
    }

    // méthode pour saluer
    public function saluer() {
        echo "Bonjour, je m'appelle {$this->nom}.<br>";
    }

    // méthode pour se présenter
    public function sePresenter() {
        echo "Je suis {$this->nom}.<br>";
    }

    // méthode pour marcher
    public function marcher() {
        echo "{$this->nom} marche.<br>";
    }
}

// Classe enfant : Homme
class Homme extends Humain {
    public function saluer() {
        echo "Je suis un homme.<br>";
    }
}

// Classe enfant : Femme
class Femme extends Humain {
    public function saluer() {
        echo "Je suis une femme.<br>";
    }
}

// Création d'un objet de la classe Homme
$homme = new Homme("Jean");
$homme->saluer();        // méthode spécifique à Homme
$homme->sePresenter();   // méthode héritée de Humain
$homme->marcher();       // méthode héritée de Humain

echo "<br>";

// Création d'un objet de la classe Femme
$femme = new Femme("Marie");
$femme->saluer();        // méthode spécifique à Femme
$femme->sePresenter();   // méthode héritée de Humain
$femme->marcher();       // méthode héritée de Humain

?>
