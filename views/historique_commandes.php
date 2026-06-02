<?php
session_start();
require_once('../config/db.php');
require_once('../models/Commande.php');

if(!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$pdo = connectToBD();
$commandes = Commande::getByClient($pdo, $_SESSION['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Historique Commandes</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>

<div class="auth-wrapper" style="max-width: 700px;">
    <div class="logo">
        <img src="../assets/images/logo.jpeg" alt="Auriva Logo" class="logo-img">
    </div>

    <div class="card">
        <h2>Historique des commandes</h2>
        <p class="card-sub">VOS ACHATS AURIVA</p>

        <?php if(empty($commandes)): ?>
            <p style="text-align:center; color:#aaa; margin: 2rem 0;">
                Aucune commande pour le moment.
            </p>

        <?php else: ?>
            <?php foreach($commandes as $commande): ?>
                <div class="commande-row">
                    <div class="commande-info">
                        <span class="commande-num">#<?= $commande['id'] ?></span>
                        <span class="commande-date"><?= $commande['date_commande'] ?></span>
                    </div>

                    <div class="commande-produit"><?= $commande['nom'] ?></div>

                    <div class="commande-footer">
                        <span class="commande-prix"><?= $commande['montant_total'] ?> MAD</span>

                        <?php if($commande['statut'] === 'livree'): ?>
                            <span class="badge livree">Livrée</span>
                        <?php elseif($commande['statut'] === 'en livraison'): ?>
                            <span class="badge expediee">En livraison</span>
                        <?php elseif($commande['statut'] === 'en preparation'): ?>
                            <span class="badge en-cours">En préparation</span>
                        <?php else: ?>
                            <span class="badge en-cours">En attente</span>
                        <?php endif; ?>

                        <a href="suivi_commande.php?id=<?= $commande['id'] ?>" class="switch-link">Suivre →</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</div>

</body>
</html>