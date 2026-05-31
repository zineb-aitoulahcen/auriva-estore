<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Auriva — Mon Panier</title>
    <link rel="stylesheet" href="../assets/css/panier.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-logo">AURIVA</div>
    <ul class="nav-links">
        <li><a href="../controllers/ProduitController.php">Accueil</a></li>
        <li><a href="panier.php" class="active">Panier</a></li>
        <li><a href="suivi_commande.php">Suivi</a></li>
        <li><a href="historique.php">Historique</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="nav-user">
        <span class="user-name"><?= $_SESSION['user']['prenom'] ?></span>
        <a href="login.php" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<main class="panier-container">
    <h1 class="page-title">Mon Panier</h1>

    <div class="panier-layout">

        <div class="panier-items">
            <!-- articles affichés par PHP ici -->
        </div>

        <aside class="panier-recap">
            <h2>Récapitulatif</h2>

            <div class="recap-livraison">
                <span>Livraison</span>
                <span>Gratuite</span>
            </div>

            <div class="recap-total">
                <span>Total</span>
                <span>0 MAD</span>
            </div>

            <form method="POST" action="../controllers/PanierController.php">
                <input type="hidden" name="action" value="valider">
                <button type="submit" class="btn-gold btn-full">Valider la commande</button>
            </form>

            <form method="POST" action="../controllers/PanierController.php">
                <input type="hidden" name="action" value="vider">
                <button type="submit" class="btn-outline btn-full">Vider le panier</button>
            </form>

        </aside>
    </div>
</main>

</body>
</html>