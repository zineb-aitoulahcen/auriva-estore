<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Inscription</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="logo">
        <img src="../assets/images/logo.jpeg" alt="Auriva Logo" class="logo-img">
    </div>

    <div class="card">
        <h2>Créer un compte</h2>
        <p class="card-sub">REJOIGNEZ L'UNIVERS AURIVA</p>

        <form action="../controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="inscription">

            <div class="row-2">
                <div>
                    <label>PRÉNOM *</label>
                    <input type="text" name="prenom" placeholder="Marie" required>
                </div>
                <div>
                    <label>NOM *</label>
                    <input type="text" name="nom" placeholder="Dupont" required>
                </div>
            </div>

            <label>ADRESSE E-MAIL *</label>
            <input type="email" name="email" placeholder="exemple@email.com" required>

            <label>TÉLÉPHONE (optionnel)</label>
            <input type="tel" name="telephone" placeholder="+212 6 00 00 00 00">

            <label>MOT DE PASSE *</label>
            <div class="input-eye">
                <input type="password" name="pwd" id="mdp" placeholder="••••••••" required>
                <span class="eye-btn" onclick="togglePassword('mdp', this)">👁</span>
            </div>

            <label>CONFIRMER LE MOT DE PASSE *</label>
            <div class="input-eye">
                <input type="password" name="confirm_pwd" id="confirm" placeholder="••••••••" required>
                <span class="eye-btn" onclick="togglePassword('confirm', this)">👁</span>
            </div>

            <div class="checkbox-row">
                <input type="checkbox" name="cgu" id="cgu" required>
                <label for="cgu" class="cgu-label">
                    J'accepte les conditions générales d'AURIVA
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