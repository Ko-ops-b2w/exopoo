<?php

class Personnages {
    protected $nom;
    protected $vie;
    protected $force;

    public function __construct($nom, $vie, $force) {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->force = $force;
    }

    // Getters
    public function getNom() {
        return $this->nom;
    }
    public function getVie() {
        return $this->vie;
    }
    public function getForce() {
        return $this->force;
    }

    // Setters
    public function setVie($vie) {
        $this->vie = $vie;
    }

    public function attaquer($adversaire) {
        if ($this->vie > 0) {
            echo "{$this->nom} attaque {$adversaire->getNom()} avec une force de {$this->force}.<br>";
            $adversaire->subirDegats($this->force);
        } else {
            echo "{$this->nom} ne peut pas attaquer, il est hors de combat.<br>";
        }
    }

    public function subirDegats($degats) {
        $this->vie -= $degats;
        if ($this->vie <= 0) {
            $this->vie = 0;
            echo "{$this->nom} est hors de combat.<br>";
        } else {
            echo "{$this->nom} subit {$degats} points de dégâts. Vie restante : {$this->vie}.<br>";
        }
    }

    public function afficherEtat() {
        echo "➡️ Nom : {$this->nom}, Vie : {$this->vie}, Force : {$this->force}.<br>";
    }
}

// Les classes enfants doivent être en dehors de la classe parent :
class Guerrier extends Personnages {
    public function __construct($nom, $vie = 120, $force = 15) {
        parent::__construct($nom, $vie, $force);
    }

    public function attaquer($adversaire) {
        echo "{$this->getNom()} attaque avec une épée !<br>";
        parent::attaquer($adversaire);
    }
}

class Voleur extends Personnages {
    public function __construct($nom, $vie = 100, $force = 12) {
        parent::__construct($nom, $vie, $force);
    }

    public function attaquer($adversaire) {
        echo "{$this->getNom()} attaque avec une dague !<br>";
        parent::attaquer($adversaire);
    }
}

class Magicien extends Personnages {
    public function __construct($nom, $vie = 90, $force = 8) {
        parent::__construct($nom, $vie, $force);
    }

    public function attaquer($adversaire) {
        echo "{$this->getNom()} lance un sort !<br>";
        parent::attaquer($adversaire);
    }
}

// Formulaire HTML (à mettre après les classes)
echo "<form method='get'>
         <label><input type='radio' name='personnage' value='Guerrier' required> ⚔️ Guerrier</label><br>
         <label><input type='radio' name='personnage' value='Voleur'> 🗡️ Voleur</label><br>
         <label><input type='radio' name='personnage' value='Magicien'> 🧙 Magicien</label><br><br>
         <button type='submit'>✅ Commencer le combat</button>
      </form><br>";
?>
<?php
// ... (classes déjà définies ici)

// Fonction pour générer un adversaire aléatoire d'une autre classe
function genererAdversaire($classeJoueur) {
    $classesDisponibles = ['Guerrier', 'Voleur', 'Magicien'];
    // Retirer la classe choisie par le joueur
    $classesAdversaire = array_filter($classesDisponibles, fn($c) => $c !== $classeJoueur);
    // $classesAdversaire = array_filter($classesDisponibles, function($c) {
    // return $c !== $classeJoueur;});

    // Choisir une classe au hasard pour l’adversaire
    $classeAleatoire = $classesAdversaire[array_rand($classesAdversaire)];
    return new $classeAleatoire("Adversaire");
}

// Traitement du formulaire
if (isset($_GET['personnage'])) {
    $classeJoueur = $_GET['personnage'];

    // Création des personnages
    $joueur = new $classeJoueur("Joueur");
    $adversaire = genererAdversaire($classeJoueur);

    echo "<h3>🔥 Début du combat entre {$joueur->getNom()} (classe : $classeJoueur) et {$adversaire->getNom()} (classe : " . get_class($adversaire) . ") !</h3><br>";

    // Combat tour par tour
    $tour = 1;
    while ($joueur->getVie() > 0 && $adversaire->getVie() > 0) {
        echo "<strong>🕛 Tour $tour :</strong><br>";

        $joueur->attaquer($adversaire);
        if ($adversaire->getVie() <= 0) break; // l'adversaire est KO

        $adversaire->attaquer($joueur);
        if ($joueur->getVie() <= 0) break; // le joueur est KO

        // Affichage des états
        $joueur->afficherEtat();
        $adversaire->afficherEtat();

        echo "<hr>";
        $tour++;
    }

    // Affichage du résultat final
    echo "<h3>🏁 Fin du combat</h3>";
    if ($joueur->getVie() > 0) {
        echo "<strong>🏆 Victoire du joueur !</strong><br>";
    } else {
        echo "<strong>💀 L'adversaire a gagné...</strong><br>";
    }
} else {
    // Affichage du formulaire si aucun personnage n’a encore été sélectionné
    echo "<form method='get'>
         <label><input type='radio' name='personnage' value='Guerrier' required> ⚔️ Guerrier</label><br>
         <label><input type='radio' name='personnage' value='Voleur'> 🗡️ Voleur</label><br>
         <label><input type='radio' name='personnage' value='Magicien'> 🧙 Magicien</label><br><br>
         <button type='submit'>✅ Commencer le combat</button>
      </form><br>";
}
?>
<?php
// Fin du script
?>

