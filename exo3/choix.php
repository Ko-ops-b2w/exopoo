<?php
session_start();
if (isset($_POST['personnage'])) {
    $_SESSION['choix'] = $_POST['personnage'];
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix du personnage</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
    <h1>Choisis ton personnage</h1>
    <form method="post">
        <label><input type="radio" name="personnage" value="Guerrier" required> ⚔️ Guerrier</label><br>
        <label><input type="radio" name="personnage" value="Voleur"> 🗡️ Voleur</label><br>
        <label><input type="radio" name="personnage" value="Magicien"> 🧙 Magicien</label><br><br>
        <button type="submit">✅ Commencer le combat</button>
    </form>
    </div>
</body>
</html>
