<?php
session_start();
require_once('../config/db.php');
require_once('../models/Commande.php');

if(!isset($_SESSION['user']['id'])) {
    header('Location: login.php');
    exit;
}

$pdo = connectToBD();
$commandes = Commande::getByClient($pdo, $_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Historique Commandes</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
    <style>
        body {
            display: block !important;
            background-color: #F5F0E8;
        }

        .navbar {
            background: #FFFFFF;
            border-bottom: 1px solid #DDD5C0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            height: 64px;
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
        }

        .nav-logo {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem;
            font-weight: 600;
            color: #C9A84C;
            letter-spacing: 6px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: #7A7060;
            text-transform: uppercase;
            transition: color 0.2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            color: #C9A84C;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.85rem;
        }

        .user-name { color: #888; }

        .btn-logout {
            text-decoration: none;
            color: #C9A84C;
            border: 1px solid #DDD5C0;
            padding: 5px 14px;
            border-radius: 8px;
            font-size: 0.8rem;
            transition: background 0.2s;
        }

        .btn-logout:hover { background: #FEF9F0; }

        .historique-wrapper {
            max-width: 750px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .historique-wrapper h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 400;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .card-sub {
            text-align: center;
            font-size: 0.72rem;
            letter-spacing: 0.2em;
            color: #C9A84C;
            margin-bottom: 2rem;
        }

        .commande-row {
            background: #FFFFFF;
            border: 1px solid #DDD5C0;
            border-radius: 12px;
            padding: 24px 28px;
            margin-bottom: 16px;
            transition: box-shadow 0.2s;
        }

        .commande-row:hover {
            box-shadow: 0 4px 16px rgba(201,168,76,0.12);
        }

        .commande-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .commande-num {
            font-weight: 600;
            color: #C9A84C;
            font-size: 0.88rem;
            letter-spacing: 1px;
        }

        .commande-date {
            font-size: 0.82rem;
            color: #aaa;
        }

        .commande-produit {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.15rem;
            color: #2C2C2C;
            margin-bottom: 16px;
        }

        .commande-footer {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .commande-prix {
            font-size: 1rem;
            font-weight: 600;
            color: #2C2C2C;
            margin-right: auto;
        }

        .badge {
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 500;
        }

        .badge.livree   { background: #D1FAE5; color: #065F46; }
        .badge.expediee { background: #DBEAFE; color: #1E40AF; }
        .badge.en-cours { background: #FEF3C7; color: #92400E; }
        .badge.annulee  { background: #FEE2E2; color: #B91C1C; }

        .commande-footer a {
            font-size: 0.82rem;
            color: #9A7A2E;
            text-decoration: none;
            border-bottom: 1px solid #9A7A2E;
            padding-bottom: 1px;
            transition: opacity 0.2s;
        }

        .commande-footer a:hover { opacity: 0.6; }

        .vide-msg {
            text-align: center;
            color: #aaa;
            margin: 60px 0;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-logo">AURIVA</div>
    <ul class="nav-links">
        <li><a href="../controllers/ProduitController.php">Accueil</a></li>
        <li><a href="panier.php">Panier</a></li>
        <li><a href="suivi_commande.php">Suivi</a></li>
        <li><a href="historique_commandes.php" class="active">Historique</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="nav-user">
        <span class="user-name"><?= $_SESSION['user']['prenom'] ?? '' ?></span>
        <a href="../controllers/AuthController.php?action=deconnexion" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<div class="historique-wrapper">
    <h2>Historique des commandes</h2>
    <p class="card-sub">VOS ACHATS AURIVA</p>

    <?php if(empty($commandes)): ?>
        <p class="vide-msg">Aucune commande pour le moment.</p>

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

                    <a href="suivi_commande.php?id=<?= $commande['id'] ?>">Suivre →</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

</body>
</html>