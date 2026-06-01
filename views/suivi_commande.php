<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Suivi Commande</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper">
    <div class="logo">
        <img src="../assets/images/logo.jpeg" alt="Auriva Logo" class="logo-img">
    </div>

    <div class="card">
        <h2>Suivi de commande</h2>
        <p class="card-sub">ÉTAT DE VOTRE COMMANDE</p>

        <div class="suivi-steps">

            <div class="step active">
                <div class="step-icon">✅</div>
                <div class="step-label">Commande passée</div>
            </div>

            <div class="step-line"></div>

            <div class="step active">
                <div class="step-icon">📦</div>
                <div class="step-label">En préparation</div>
            </div>

            <div class="step-line"></div>

            <div class="step">
                <div class="step-icon">🚚</div>
                <div class="step-label">Expédiée</div>
            </div>

            <div class="step-line"></div>

            <div class="step">
                <div class="step-icon">🏠</div>
                <div class="step-label">Livrée</div>
            </div>

        </div>

        <p class="switch-link">
            <a href="historique_commandes.php">Voir mes commandes</a>
        </p>
    </div>
</div>

</body>
</html>