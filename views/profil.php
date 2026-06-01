<?php
require_once '../config/session.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Mon Profil</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="logo">
        <img src="../assets/images/logo.jpeg" alt="Auriva Logo" class="logo-img">
    </div>

    <div class="card">
        <h2>Mon Profil</h2>

        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="profil">

            <label>PRÉNOM</label>
            <input type="text" name="prenom" placeholder="Votre prénom" required>

            <label>NOM</label>
            <input type="text" name="nom" placeholder="Votre nom" required>

            <label>ADRESSE E-MAIL</label>
            <input type="email" name="email" placeholder="exemple@email.com" required>

            <label>TÉLÉPHONE</label>
            <input type="tel" name="telephone" placeholder="+212 6 00 00 00 00">

            <label>NOUVEAU MOT DE PASSE</label>
            <div class="input-eye">
                <input type="password" name="pwd" id="mdp" placeholder="••••••••">
                <span class="eye-btn" onclick="togglePassword('mdp', this)">👁</span>
            </div>

            <button type="submit" class="btn-primary">MODIFIER MON PROFIL</button>
        </form>

        <p class="switch-link">
            <a href="login.php">Se déconnecter</a>
        </p>
    </div>
</div>

<script src="../assets/js/auth.js"></script>
</body>
</html>