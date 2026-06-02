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
}
?>
<!-- NAVBAR -->
  <nav class="navbar">
    <div class="nav-left">
      <a href="../index.php" class="logo">AURIVA</a>
      <a href="../index.php" class="nav-link active">Accueil</a>
      <a href="../views/panier.php" class="nav-link">Panier <span class="cart-badge"><?php echo $nb_articles; ?></span></a>
      <a href="../views/suivi_commande.php" class="nav-link">Suivi</a>
     <a href="../views/historique_commandes.php" class="nav-link">Historique</a>
     <a href="../views/contact.php" class="nav-link">Contact</a>
      <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'){ ?>
        <a href="../controllers/GestionProduitController.php" class="nav-link">Produits</a>
        <a href="../controllers/ClientController.php" class="nav-link">Clients</a>
        <a href="../controllers/StatistiquesController.php" class="nav-link">Statistiques</a>
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
            <a href="../views/login.php">Se connecter</a>
            <a href="../views/register.php">S'inscrire</a>
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
    <form method="GET" action="../controllers/ProduitController.php">
      <!-- conserver les valeurs de recherche si déjà tapées -->
      <?php if (!empty($recherche)): ?>
        <input type="hidden" name="recherche" value="<?php echo htmlspecialchars($recherche); ?>">
      <?php endif; ?>

      <h3 class="filter-title">FILTRES</h3>

      <div class="filter-group">
        <label>Marque</label>
        <select name="marque">
          <option value="">Toutes</option>
          <option value="Chanel"  <?php if(($marque??'')==='Chanel')  echo 'selected'; ?>>Chanel</option>
          <option value="Dior"    <?php if(($marque??'')==='Dior')    echo 'selected'; ?>>Dior</option>
          <option value="YSL"     <?php if(($marque??'')==='YSL')     echo 'selected'; ?>>YSL</option>
          <option value="Guerlain"<?php if(($marque??'')==='Guerlain')echo 'selected'; ?>>Guerlain</option>
          <option value="Hermès"  <?php if(($marque??'')==='Hermès')  echo 'selected'; ?>>Hermès</option>
          <option value="Givenchy"<?php if(($marque??'')==='Givenchy')echo 'selected'; ?>>Givenchy</option>
        </select>
      </div>

      <div class="filter-group">
        <label>Prix max (MAD)</label>
        <input type="range" id="filterPrix" name="prix_max" min="100" max="3000"
              value="<?php echo $prix_max ?? 3000; ?>" step="50" />
        <span class="prix-val" id="prixVal">≤ <?php echo $prix_max ?? 3000; ?> MAD</span>
      </div>

      <div class="filter-group">
        <label>Famille olfactive</label>
        <select name="famille">
          <option value="">Toutes</option>
          <option value="Floral"   <?php if(($famille??'')==='Floral')   echo 'selected'; ?>>Floral</option>
          <option value="Oriental" <?php if(($famille??'')==='Oriental') echo 'selected'; ?>>Oriental</option>
          <option value="Boisé"    <?php if(($famille??'')==='Boisé')    echo 'selected'; ?>>Boisé</option>
          <option value="Frais"    <?php if(($famille??'')==='Frais')    echo 'selected'; ?>>Frais</option>
          <option value="Fruité"   <?php if(($famille??'')==='Fruité')   echo 'selected'; ?>>Fruité</option>
        </select>
      </div>

      <div class="filter-group">
        <label>Taille</label>
        <select name="taille">
          <option value="">Toutes</option>
          <option value="30ml" <?php if(($taille??'')==='30ml') echo 'selected'; ?>>30 ml</option>
          <option value="50ml" <?php if(($taille??'')==='50ml') echo 'selected'; ?>>50 ml</option>
          <option value="100ml"<?php if(($taille??'')==='100ml')echo 'selected'; ?>>100 ml</option>
          <option value="200ml"<?php if(($taille??'')==='200ml')echo 'selected'; ?>>200 ml</option>
        </select>
      </div>

      <button type="submit" class="reset-btn" style="background:var(--gold);color:#fff;border-color:var(--gold);margin-bottom:8px;">
        Appliquer
      </button>
      <a href="../controllers/ProduitController.php" class="reset-btn" style="display:block;text-align:center;text-decoration:none;">
        Réinitialiser
      </a>
    </form>
  </aside>

    <!-- PRODUITS -->
    <section class="products-section">
      <div class="products-header">
        <span><?php echo count($produits); ?> parfums trouvés</span>
        <form method="GET" action="../controllers/ProduitController.php" style="display:inline">
          <!-- préserver les filtres actifs -->
          <?php foreach(['recherche','marque','prix_max','famille','taille','genre','categorie'] as $param): ?>
            <?php if(!empty($$param)): ?>
              <input type="hidden" name="<?php echo $param; ?>" value="<?php echo htmlspecialchars($$param); ?>">
            <?php endif; ?>
          <?php endforeach; ?>
          <select name="tri" onchange="this.form.submit()">
            <option value="nouveau"   <?php if(($tri??'')==='nouveau')   echo 'selected'; ?>>Nouveautés</option>
            <option value="prix-asc"  <?php if(($tri??'')==='prix-asc')  echo 'selected'; ?>>Prix croissant</option>
            <option value="prix-desc" <?php if(($tri??'')==='prix-desc') echo 'selected'; ?>>Prix décroissant</option>
          </select>
        </form>
      </div>

      <!-- Grille produits : sera générée par PHP -->
      <div class="products-grid">
        <?php if (empty($produits)){ ?>
          <p>Aucun produit trouvé.</p>
        <?php } else{ 
          foreach ($produits as $p){ ?>
          <div class="card">
            <div class="card-img">
              <?php if(!empty($p['image'])): ?>
                <img src="/auriva-estore/<?php echo $p['image']; ?>" alt="<?php echo $p['nom']; ?>">
              <?php else: ?>
                🧴
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="card-name"><?php echo $p['nom']; ?></div>
              <div class="card-sub"><?php echo $p['marque']; ?></div>
              <div class="card-price"><?php echo number_format($p['prix'], 2); ?> MAD</div>
              <form method="POST" action="../controllers/PanierController.php">
                <input type="hidden" name="action" value="ajouter">
                <input type="hidden" name="produit_id" value="<?php echo $p['id']; ?>">
                <button type="submit" class="add-btn">+ Panier</button>
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