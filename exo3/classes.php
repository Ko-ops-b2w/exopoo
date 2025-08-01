<?php

class Personnages {
    protected string $nom;
    protected int $vie;
    protected int $force;

    public function __construct(string $nom, int $vie, int $force) {
        $this->nom = $nom;
        $this->vie = $vie;
        $this->force = $force;
    }

    public function getNom(): string {
        return $this->nom;
    }

    public function getVie(): int {
        return $this->vie;
    }

    public function getForce(): int {
        return $this->force;
    }

    public function setVie(int $vie) {
        $this->vie = $vie;
    }

    public function attaquer(Personnages $adversaire) {
        if ($this->vie > 0) {
            echo "{$this->nom} attaque {$adversaire->getNom()} avec une force de {$this->force}.<br>";
            $adversaire->subirDegats($this->force);
        } else {
            echo "{$this->nom} ne peut pas attaquer, il est hors de combat.<br>";
        }
    }

    public function subirDegats(int $degats) {
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

class Guerrier extends Personnages {
    public function __construct(string $nom, int $vie = 120, int $force = 15) {
        parent::__construct($nom, $vie, $force);
    }

    public function attaquer(Personnages $adversaire) {
        echo "{$this->getNom()} attaque avec une épée !<br>";
        parent::attaquer($adversaire);
    }
}

class Voleur extends Personnages {
    public function __construct(string $nom, int $vie = 100, int $force = 12) {
        parent::__construct($nom, $vie, $force);
    }

    public function subirDegats(int $degats) {
        if (rand(1, 100) <= 30) {
            echo "{$this->getNom()} esquive l'attaque ! Aucun dégât reçu.<br>";
        } else {
            parent::subirDegats($degats);
        }
    }
}

class Magicien extends Personnages {
    public function __construct(string $nom, int $vie = 90, int $force = 8) {
        parent::__construct($nom, $vie, $force);
    }

    public function attaquer(Personnages $adversaire) {
        if (rand(1, 100) <= 50) {
            $degats = $this->getForce() * 2;
            echo "{$this->getNom()} lance un sort puissant ! Il inflige {$degats} dégâts.<br>";
            $adversaire->subirDegats($degats);
        } else {
            parent::attaquer($adversaire);
        }
    }
}
