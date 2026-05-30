<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auriva — Mon Panier</title>
    <link rel="stylesheet" href="../assets/css/panier.css">
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-logo">AURIVA</div>
    <ul class="nav-links">
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="panier.php" class="active">Panier</a></li>
        <li><a href="suivi_commande.php">Suivi</a></li>
        <li><a href="historique.php">Historique</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
    <div class="nav-user">
        <span class="user-name"><!-- nom user ici --></span>
        <a href="login.php" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<!-- CONTENU PRINCIPAL -->
<main class="panier-container">

    <h1 class="page-title">Mon Panier</h1>

    <div class="panier-layout">

        <!-- LISTE DES ARTICLES -->
        <div class="panier-items">

            <!-- Les articles seront affichés ici par PHP -->
            <div class="panier-vide">
                <p>Votre panier est vide.</p>
                <a href="accueil.php" class="btn-gold">Découvrir nos parfums</a>
            </div>

        </div>

        <!-- RÉCAPITULATIF -->
        <aside class="panier-recap">
            <h2>Récapitulatif</h2>

            <!-- Les lignes seront affichées ici par PHP -->

            <div class="recap-livraison">
                <span>Livraison</span>
                <span>Gratuite</span>
            </div>

            <div class="recap-total">
                <span>Total</span>
                <span>0 MAD</span>
            </div>

            <button class="btn-gold btn-full">Valider la commande</button>
            <button class="btn-outline btn-full">Vider le panier</button>
        </aside>

    </div>
</main>

</body>
</html>