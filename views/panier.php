<?php 
    session_start(); 
    require_once '../config/db.php';
    require_once '../models/Panier.php';
    $client_id = $_SESSION['user']['id'];
    $produits  = Panier::getPanier($pdo, $client_id);
    $total     = Panier::calculerTotal($pdo, $client_id);
?>
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

                <?php if (empty($produits)){ ?>
                    <div class="panier-vide">
                        <p>Votre panier est vide.</p>
                        <a href="../controllers/ProduitController.php" class="btn-gold">Découvrir nos parfums</a>
                    </div>
                <?php } else { ?>
                    <?php foreach ($produits as $p){ ?>
                    <div class="panier-card">
                        <div class="panier-card-img">
                            <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['nom']; ?>">
                        </div>
                        <div class="panier-card-info">
                            <h3><?php echo $p['nom']; ?> <span class="marque"><?php echo $p['marque']; ?></span></h3>
                            <p class="taille"><?php echo $p['taille']; ?></p>
                            <p class="prix-unitaire"><?php echo $p['prix']; ?> MAD / unité</p>
                        </div>
                        <div class="panier-card-actions">
                            <form method="POST" action="../controllers/PanierController.php">
                                <input type="hidden" name="action" value="modifier">
                                <input type="hidden" name="panier_id" value="<?php echo $p['id']; ?>">
                                <button type="submit" name="sens" value="moins" class="qty-btn">−</button>
                                <span class="qty-val"><?php echo $p['quantite']; ?></span>
                                <button type="submit" name="sens" value="plus" class="qty-btn">+</button>
                            </form>
                            <p class="prix-total-ligne"><?php echo $p['prix'] * $p['quantite']; ?> MAD</p>
                            <form method="POST" action="../controllers/PanierController.php">
                                <input type="hidden" name="action" value="supprimer">
                                <input type="hidden" name="panier_id" value="<?php echo $p['id']; ?>">
                                <button type="submit" class="btn-suppr">✕</button>
                            </form>
                        </div>
                    </div>
                <?php } } ?>
        </div>

        <aside class="panier-recap">
            <h2>Récapitulatif</h2>

            <?php foreach ($produits as $p){ ?>
            <div class="recap-ligne">
                <span><?php echo $p['nom']; ?> × <?php echo $p['quantite']; ?></span>
                <span><?php echo $p['prix'] * $p['quantite']; ?> MAD</span>
            </div>
            <?php } ?>

            <div class="recap-livraison">
                <span>Livraison</span>
                <span>Gratuite</span>
            </div>

            <div class="recap-total">
                <span>Total</span>
                <span><?php echo $total; ?> MAD</span>
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