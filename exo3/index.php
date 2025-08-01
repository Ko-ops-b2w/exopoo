<?php
session_start();
require_once 'classes.php';

// Si aucun personnage sélectionné, redirige vers la page de choix
if (!isset($_SESSION['choix'])) {
    header('Location: choix.php');
    exit;
}

// Réinitialiser la partie
if (isset($_GET['reset'])) {
    unset($_SESSION['joueur'], $_SESSION['adversaire'], $_SESSION['choix']);
    header("Location: choix.php");
    exit;
}

// Initialisation
if (!isset($_SESSION['joueur'])) {
    $choix = $_SESSION['choix'];
    $joueur = match ($choix) {
        'Guerrier' => new Guerrier("Joueur"),
        'Voleur'   => new Voleur("Joueur"),
        'Magicien' => new Magicien("Joueur"),
        default    => new Guerrier("Joueur"),
    };
    $_SESSION['joueur'] = serialize($joueur);

    $classes = ['Guerrier', 'Voleur', 'Magicien'];
    $randomClass = $classes[array_rand($classes)];
    $adversaire = match ($randomClass) {
        'Guerrier' => new Guerrier("Adversaire"),
        'Voleur'   => new Voleur("Adversaire"),
        'Magicien' => new Magicien("Adversaire"),
    };
    $_SESSION['adversaire'] = serialize($adversaire);
}

// Récupération des objets
$joueur = unserialize($_SESSION['joueur']);
$adversaire = unserialize($_SESSION['adversaire']);

ob_start();
if (isset($_POST['action']) && $joueur->getVie() > 0 && $adversaire->getVie() > 0) {
    $joueur->attaquer($adversaire);
    if ($adversaire->getVie() > 0) {
        $adversaire->attaquer($joueur);
    }
    $_SESSION['joueur'] = serialize($joueur);
    $_SESSION['adversaire'] = serialize($adversaire);
}
$combatLog = ob_get_clean(); 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RPG Combat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>⚔️ Combat RPG</h1>

        <h2>👤 Joueur (<?= $_SESSION['choix'] ?>)</h2>
        <?php $joueur->afficherEtat(); ?>

        <h2>🧟 Adversaire</h2>
        <?php $adversaire->afficherEtat(); ?>

        <hr>

        <?php if ($joueur->getVie() > 0 && $adversaire->getVie() > 0): ?>
            <form method="post">
                <button type="submit" name="action" value="attack">👉 Attaquer</button>
            </form>
        <?php else: ?>
            <div class="result <?= $joueur->getVie() > 0 ? 'success' : '' ?>">
                <?php
                if ($joueur->getVie() <= 0) {
                    echo "❌ {$joueur->getNom()} a été vaincu.";
                } elseif ($adversaire->getVie() <= 0) {
                    echo "🏆 {$joueur->getNom()} a gagné !";
                }
                ?>
            </div>
            <a class="reset-link" href="?reset=1">🔁 Rejouer avec un nouveau personnage</a>
        <?php endif; ?>

        <div class="log">
            <h3>📜 Journal du Combat</h3>
            <?= $combatLog ?>
        </div>
    </div>
</body>
</html>
