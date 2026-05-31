<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>AURIVA — Parfums d'exception</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/auriva-estore/assets/css/accueil.css" />
</head>
<body>
  <?php
  $nb_articles = 0;
  if (isset($_SESSION['user'])) {
      $nb_articles = Panier::compterArticles($pdo, $_SESSION['user']['id']);
  }?>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-left">
      <a href="accueil.php" class="logo">AURIVA</a>
      <a href="accueil.php" class="nav-link active">Accueil</a>
      <a href="../views/panier.php" class="nav-link">Panier <span class="cart-badge"><?php echo $nb_articles; ?></span></a>
      <a href="../views/suivi.php" class="nav-link">Suivi</a>
      <a href="../views/historique.php" class="nav-link">Historique</a>
      <a href="../views/contact.php" class="nav-link">Contact</a>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'){ ?>
        <a href="../views/admin/gestion_produits.php" class="nav-link">Produits</a>
        <a href="../views/admin/gestion_clients.php" class="nav-link">Clients</a>
        <a href="../views/admin/statistiques.php" class="nav-link">Statistiques</a>
      <?php } ?>
    </div>
    <div class="nav-right">
      <div class="user-menu">
          <?php if (isset($_SESSION['user'])) { ?>
          <button class="user-btn">
            &#9776; <span><?php echo $_SESSION['user']['prenom']; ?></span>
          </button>
          <div class="user-dropdown">
            <a href="../controllers/AuthController.php?action=deconnexion">Se déconnecter</a>
          </div>
          <?php } else { ?>
          <button class="user-btn">
            &#9776; <span>Compte</span>
          </button>
          <div class="user-dropdown">
            <a href="login.php">Se connecter</a>
            <a href="register.php">S'inscrire</a>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </nav>

 <!-- HERO -->
<section class="hero">
    <h1>Découvrez nos parfums d'exception</h1>
    <p>Explorez notre collection et trouvez votre signature olfactive</p>
    <form method="GET" action="../controllers/ProduitController.php">
        <div class="search-bar">
            <input type="text" name="recherche" placeholder="Rechercher un parfum, une marque..." />
            <select name="categorie">
                <option value="">Toutes catégories</option>
                <option value="femme">Femme</option>
                <option value="homme">Homme</option>
                <option value="mixte">Mixte</option>
            </select>
            <button type="submit">Chercher</button>
        </div>
    </form>
</section>

  <!-- MAIN -->
  <div class="main-layout">

    <!-- SIDEBAR FILTRES -->
    <aside class="sidebar">
      <h3 class="filter-title">FILTRES</h3>

      <div class="filter-group">
        <label>Marque</label>
        <select name="marque">
          <option value="">Toutes</option>
          <option value="Chanel">Chanel</option>
          <option value="Dior">Dior</option>
          <option value="YSL">YSL</option>
          <option value="Guerlain">Guerlain</option>
          <option value="Hermès">Hermès</option>
          <option value="Givenchy">Givenchy</option>
        </select>
      </div>

      <div class="filter-group">
        <label>Prix max (MAD)</label>
        <input type="range" id="filterPrix" name="prix_max" min="100" max="3000" value="3000" step="50" />
        <span class="prix-val" id="prixVal">≤ 3000 MAD</span>
      </div>

      <div class="filter-group">
        <label>Famille olfactive</label>
        <select name="famille">
          <option value="">Toutes</option>
          <option value="Floral">Floral</option>
          <option value="Oriental">Oriental</option>
          <option value="Boisé">Boisé</option>
          <option value="Frais">Frais</option>
          <option value="Fruité">Fruité</option>
        </select>
      </div>

      <div class="filter-group">
        <label>Taille</label>
        <select name="taille">
          <option value="">Toutes</option>
          <option value="30ml">30 ml</option>
          <option value="50ml">50 ml</option>
          <option value="100ml">100 ml</option>
          <option value="200ml">200 ml</option>
        </select>
      </div>

      <div class="filter-group">
        <label>Genre</label>
        <select name="genre">
          <option value="">Tous</option>
          <option value="Femme">Femme</option>
          <option value="Homme">Homme</option>
          <option value="Mixte">Mixte</option>
        </select>
      </div>

      <button class="reset-btn" type="reset">Réinitialiser</button>
    </aside>

    <!-- PRODUITS -->
    <section class="products-section">
      <div class="products-header">
        <span><?php echo count($produits); ?> parfums trouvés</span>
        <select name="tri">
          <option value="prix-asc">Prix croissant</option>
          <option value="prix-desc">Prix décroissant</option>
          <option value="nouveau">Nouveautés</option>
        </select>
      </div>

      <!-- Grille produits : sera générée par PHP -->
      <div class="products-grid">
        <?php if (empty($produits)){ ?>
          <p>Aucun produit trouvé.</p>
        <?php } else{ 
          foreach ($produits as $p){ ?>
          <div class="product-card">
            <img src="<?php echo $p['image']; ?>" alt="<?php echo $p['nom']; ?>">
            <div class="product-info">
                <h3><?php echo $p['nom']; ?></h3>
                <p class="marque"><?php echo $p['marque']; ?></p>
                <p class="prix"><?php echo $p['prix']; ?> MAD</p>
                <form method="POST" action="../controllers/PanierController.php">
                    <input type="hidden" name="action" value="ajouter">
                    <input type="hidden" name="produit_id" value="<?php echo $p['id']; ?>">
                    <button type="submit" class="btn-add">+ Panier</button>
                </form>
            </div>
         </div>
          <?php } } ?>
          
      </div>
    </section>

  </div>

  <script src="/auriva-estore/assets/js/accueil.js"></script>
</body>
</html>