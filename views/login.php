<?php
session_start();
$erreur = $_SESSION['erreur'] ?? '';
unset($_SESSION['erreur']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Connexion</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">        <!-- ← zid had div hna -->

    <div class="logo">
        <img src="../assets/images/logo.jpeg" alt="Auriva Logo" class="logo-img">
    </div>

    <?php if ($erreur): ?>
        <div class="alert error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Connexion</h2>

        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="connexion">

            <label>Adresse e-mail</label>
            <input type="email" name="email" placeholder="exemple@email.com" required>

            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" placeholder="••••••••" required>

            <button type="submit" class="btn-primary">SE CONNECTER</button>
        </form>

        <p class="switch-link">
            — ou —<br>
            <a href="register.php">Pas encore de compte ? S'inscrire</a>
        </p>
    </div>

</div>                            <!-- ← u siflo hna -->

<script src="../assets/js/auth.js"></script>
</body>
</html>