<?php
require_once '../config/session.php';
requireConnexion();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Contact</title>
    <link rel="stylesheet" href="../assets/css/panier.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-logo">AURIVA</div>
    <ul class="nav-links">
        <li><a href="../controllers/ProduitController.php">Accueil</a></li>
        <li><a href="panier.php">Panier</a></li>
        <li><a href="suivi_commande.php">Suivi</a></li>
        <li><a href="historique_commandes.php">Historique</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
    </ul>
    <div class="nav-user">
        <span class="user-name"><?= $_SESSION['prenom'] ?? '' ?></span>
        <a href="../controllers/AuthController.php?action=deconnexion" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<main class="panier-container">
    <h1 class="page-title">Contactez-nous</h1>

    <div class="contact-box">

        <div class="contact-item">
            <span class="contact-icon">📞</span>
            <div>
                <p class="contact-label">Téléphone</p>
                <p class="contact-value">+212 6 97 25 00 00</p>
            </div>
        </div>

        <div class="contact-item">
            <span class="contact-icon">✉️</span>
            <div>
                <p class="contact-label">Email</p>
                <p class="contact-value">contact@auriva.ma</p>
            </div>
        </div>

    </div>
</main>

<style>
.contact-box {
    display: flex;
    flex-direction: column;
    gap: 24px;
    max-width: 500px;
    margin: 60px auto;
    background: #fff;
    border: 1px solid #e8e0d0;
    border-radius: 12px;
    padding: 40px;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 20px;
}

.contact-icon {
    font-size: 28px;
}

.contact-label {
    font-size: 12px;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}

.contact-value {
    font-size: 16px;
    color: #b8960c;
    font-weight: 500;
}
</style>

</body>
</html>