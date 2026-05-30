<?php
session_start();
$erreur = $_SESSION['erreur'] ?? '';
$succes = $_SESSION['succes'] ?? '';
unset($_SESSION['erreur'], $_SESSION['succes']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Créer un compte</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
<div class="auth-wrapper">
<div class="logo">
    <img src="../assets/images/logo.jpeg" alt="Auriva Logo" class="logo-img">
</div>

    <?php if ($erreur): ?>
        <div class="alert error"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>
    <?php if ($succes): ?>
        <div class="alert success"><?= htmlspecialchars($succes) ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Créer un compte</h2>
        <p class="card-sub">REJOIGNEZ L'UNIVERS AURIVA</p>

        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="inscription">

            <!-- Prénom + Nom -->
            <div class="row-2">
                <div>
                    <label>PRÉNOM <span class="required">*</span></label>
                    <input type="text" name="prenom" placeholder="Marie" required>
                </div>
                <div>
                    <label>NOM <span class="required">*</span></label>
                    <input type="text" name="nom" placeholder="Dupont" required>
                </div>
            </div>

            <!-- Email -->
            <label>ADRESSE E-MAIL <span class="required">*</span></label>
            <input type="email" name="email" placeholder="exemple@email.com" required>

            <!-- Téléphone -->
            <label>TÉLÉPHONE <span class="optional">(optionnel)</span></label>
            <input type="tel" name="telephone" placeholder="+212 6 00 00 00 00">

            <!-- Mot de passe -->
            <label>MOT DE PASSE <span class="required">*</span></label>
            <div class="input-eye">
                <input type="password" name="mot_de_passe" id="mdp" placeholder="••••••••" required>
                <span class="eye-btn" onclick="togglePassword('mdp', this)">👁</span>
            </div>

            <!-- Confirmer -->
            <label>CONFIRMER LE MOT DE PASSE <span class="required">*</span></label>
            <div class="input-eye">
                <input type="password" name="confirm_mdp" id="confirm" placeholder="••••••••" required>
                <span class="eye-btn" onclick="togglePassword('confirm', this)">👁</span>
            </div>

            <!-- CGU -->
            <div class="checkbox-row">
                <input type="checkbox" name="cgu" id="cgu" required>
                <label for="cgu" class="cgu-label">
                    J'accepte les conditions générales et la politique de confidentialité d'AURIVA
                </label>
            </div>

            <button type="submit" class="btn-primary">CRÉER MON COMPTE</button>
        </form>

        <p class="switch-link">
            Déjà un compte ? <a href="login.php">Se connecter</a>
        </p>
    </div>

</div>
<script src="../assets/js/auth.js"></script>
</body>
</html>