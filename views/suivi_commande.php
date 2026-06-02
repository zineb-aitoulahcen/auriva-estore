<?php
session_start();
require_once('../config/db.php');
require_once('../models/Commande.php');

if(!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

$pdo = connectToBD();
$id = $_GET['id'] ?? 0;

if($id) {
    $commande = Commande::getById($pdo, $id);
} else {
    $commandes = Commande::getByClient($pdo, $_SESSION['user']['id']);
    $commande = !empty($commandes) ? $commandes[0] : null;
}

if(!$commande) {
    die("Aucune commande trouvée.");
}
?>
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
        <p class="card-sub">COMMANDE #<?= $commande['id'] ?></p>

        <div class="suivi-steps">

            <div class="step <?= in_array($commande['statut'], ['en attente','en preparation','en livraison','livree']) ? 'active' : '' ?>">
                <div class="step-icon">✅</div>
                <div class="step-label">Commande passée</div>
            </div>

            <div class="step-line"></div>

            <div class="step <?= in_array($commande['statut'], ['en preparation','en livraison','livree']) ? 'active' : '' ?>">
                <div class="step-icon">📦</div>
                <div class="step-label">En préparation</div>
            </div>

            <div class="step-line"></div>

            <div class="step <?= in_array($commande['statut'], ['en livraison','livree']) ? 'active' : '' ?>">
                <div class="step-icon">🚚</div>
                <div class="step-label">En livraison</div>
            </div>

            <div class="step-line"></div>

            <div class="step <?= $commande['statut'] === 'livree' ? 'active' : '' ?>">
                <div class="step-icon">🏠</div>
                <div class="step-label">Livrée</div>
            </div>

        </div>

        <p class="switch-link">
            <a href="/auriva-estore/views/historique_commandes.php">← Voir mes commandes</a>
        </p>
    </div>
</div>

</body>
</html>