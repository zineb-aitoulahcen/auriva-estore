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

        .suivi-wrapper {
            max-width: 560px;
            margin: 60px auto;
            padding: 0 20px;
        }

        .suivi-card {
            background: #FFFFFF;
            border: 1px solid #DDD5C0;
            border-radius: 12px;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .suivi-card h2 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.8rem;
            font-weight: 400;
            margin-bottom: 0.4rem;
        }

        .card-sub {
            font-size: 0.72rem;
            letter-spacing: 0.2em;
            color: #C9A84C;
            margin-bottom: 2rem;
        }

        .suivi-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 2rem 0;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            opacity: 0.25;
        }

        .step.active { opacity: 1; }

        .step-icon { font-size: 1.8rem; }

        .step-label {
            font-size: 0.68rem;
            letter-spacing: 0.05em;
            color: #9A7A2E;
            text-align: center;
            font-weight: 600;
            max-width: 70px;
        }

        .step-line {
            width: 40px;
            height: 1px;
            background: #DDD5C0;
            margin-bottom: 24px;
            flex-shrink: 0;
        }

        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            font-size: 0.85rem;
            color: #9A7A2E;
            text-decoration: none;
            border-bottom: 1px solid #9A7A2E;
            padding-bottom: 1px;
            transition: opacity 0.2s;
        }

        .back-link:hover { opacity: 0.6; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-logo">AURIVA</div>
    <ul class="nav-links">
        <li><a href="../controllers/ProduitController.php">Accueil</a></li>
        <li><a href="panier.php">Panier</a></li>
        <li><a href="suivi_commande.php" class="active">Suivi</a></li>
        <li><a href="historique_commandes.php">Historique</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="nav-user">
        <span class="user-name"><?= $_SESSION['user']['prenom'] ?? '' ?></span>
        <a href="../controllers/AuthController.php?action=deconnexion" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<div class="suivi-wrapper">
    <div class="suivi-card">
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

        <a href="historique_commandes.php" class="back-link">← Voir mes commandes</a>
    </div>
</div>

</body>
</html>