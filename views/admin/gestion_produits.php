<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURIVA — Gestion Produits</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/auriva-estore/assets/css/gestion_produits.css">
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar">
    <div class="nav-left">
        <a href="../views/accueil.php" class="logo">AURIVA</a>
        <a href="../index.php"                        class="nav-link">Accueil</a>
        <a href="../controllers/GestionProduitController.php"        class="nav-link active">Produits</a>
        <a href="../controllers/ClientController.php"         class="nav-link">Clients</a>
        <a href="../controllers/StatistiquesController.php"             class="nav-link">Statistiques</a>
    </div>
    <div class="nav-right">
        <span class="admin-badge">Admin</span>
        <a href="../controllers/AuthController.php?action=deconnexion" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<!-- ── PAGE ── -->
<div class="page">

    <!-- En-tête -->
    <div class="page-header">
        <div class="page-title">
            Gestion des produits
            <span>Gérez le catalogue de parfums de la boutique</span>
        </div>
        <div class="stats-row">
            <div class="stat-box">
                <span class="num"><?= $totalProduits ?></span>
                <span class="lbl">Produits</span>
            </div>
            <div class="stat-box">
                <span class="num"><?= count($produits) ?></span>
                <span class="lbl">Affichés</span>
            </div>
            <button class="btn-ajouter" onclick="ouvrirModalAjout()">+ Ajouter un produit</button>
        </div>
    </div>

    <!-- Alert -->
    <?php if ($message): ?>
        <div class="alert <?= $messageType ?>">
            <?= ($message) ?>
        </div>
    <?php endif; ?>

    <!-- Toolbar recherche -->
    <div class="toolbar">
        <form class="search-form" method="GET" action="">
            <input
                type="text"
                name="recherche"
                placeholder="Rechercher par nom..."
                value="<?= ($terme) ?>"
            >
            <button type="submit">Chercher</button>
        </form>
        <?php if ($terme): ?>
            <a href="GestionProduitController.php" class="btn-reset-search">✕ Réinitialiser</a>
        <?php endif; ?>
        <span class="result-count"><?= count($produits) ?> résultat(s)</span>
    </div>

    <!-- Tableau -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Nom &amp; Marque</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Taille</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($produits)): ?>
                <tr>
                    <td colspan="7">
                        <div class="empty">
                            <span>🧴</span>
                            Aucun produit trouvé.
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <!-- Image -->
                    <td>
                        <?php if (!empty($p['image'])): ?>
                            <img src="/auriva-estore/<?= $p['image'] ?>" alt="<?= $p['nom'] ?>" class="product-thumb">
                        <?php else: ?>
                            <div class="product-thumb-placeholder">🧴</div>
                        <?php endif; ?>
                    </td>

                    <!-- Nom & Marque -->
                    <td>
                        <div class="product-name"><?= $p['nom'] ?></div>
                        <div class="product-brand"><?= $p['marque'] ?? '' ?></div>
                    </td>

                    <!-- Catégorie -->
                    <td>
                        <span class="badge badge-<?= $p['categorie'] ?>">
                            <?= ($p['categorie']) ?>
                        </span>
                    </td>

                    <!-- Prix -->
                    <td class="prix"><?= $p['prix'], 2 ?> MAD</td>

                    <!-- Stock -->
                    <td>
                        <span class="<?= $p['stock'] <= 5 ? 'stock-low' : 'stock-ok' ?>">
                            <?= $p['stock'] ?>
                        </span>
                    </td>

                    <!-- Taille -->
                    <td><?= ($p['taille'] ?? '—') ?></td>

                    <!-- Actions -->
                    <td>
                        <div class="actions">
                            <button class="btn-edit"
                                onclick="ouvrirModalModifier(
                                    <?= $p['id'] ?>,
                                    '<?= $p['nom'] ?>',
                                    '<?= $p['description'] ?? '' ?>',
                                    <?= $p['prix'] ?>,
                                    <?= $p['stock'] ?>,
                                    '<?= $p['categorie'] ?>',
                                    '<?= $p['marque'] ?? ''?>',
                                    '<?= $p['taille'] ?? '' ?>'
                                )">
                                Modifier
                            </button>
                            <button class="btn-delete"
                                onclick="confirmerSuppression(<?= $p['id'] ?>, '<?= $p['nom'] ?>')">
                                Supprimer
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div><!-- fin .page -->


<!-- ══════════════════════════════════════════════════════════
     MODAL — AJOUTER / MODIFIER
═══════════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="modal-produit-overlay" onclick="fermerModalProduit()">
    <div class="modal modal-lg" onclick="event.stopPropagation()">
        <h3 id="modal-produit-titre">Ajouter un produit</h3>

        <form id="form-produit"
              method="POST"
              action="../controllers/GestionProduitController.php"
              enctype="multipart/form-data">

            <input type="hidden" name="action" id="form-action" value="ajouter">
            <input type="hidden" name="id"     id="form-id"     value="">

            <div class="form-grid">

                <div class="form-group full">
                    <label>Nom du parfum *</label>
                    <input type="text" name="nom" id="form-nom" required placeholder="Ex : Oud Royal">
                </div>

                <div class="form-group">
                    <label>Marque</label>
                    <input type="text" name="marque" id="form-marque" placeholder="Ex : Auriva">
                </div>

                <div class="form-group">
                    <label>Catégorie *</label>
                    <select name="categorie" id="form-categorie" required>
                        <option value="">-- Choisir --</option>
                        <option value="homme">Homme</option>
                        <option value="femme">Femme</option>
                        <option value="mixte">Mixte</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Prix (MAD) *</label>
                    <input type="number" name="prix" id="form-prix" step="0.01" min="0" required placeholder="Ex : 299.00">
                </div>

                <div class="form-group">
                    <label>Stock *</label>
                    <input type="number" name="stock" id="form-stock" min="0" required placeholder="Ex : 50">
                </div>

                <div class="form-group">
                    <label>Taille</label>
                    <input type="text" name="taille" id="form-taille" placeholder="Ex : 50ml">
                </div>

                <div class="form-group">
                    <label>Image du produit</label>
                    <input type="file" name="image" id="form-image" accept="image/*">
                </div>

                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description" id="form-description" rows="3"
                              placeholder="Description du parfum..."></textarea>
                </div>

            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="fermerModalProduit()">Annuler</button>
                <button type="submit" class="btn-confirm" id="btn-submit">Ajouter</button>
            </div>

        </form>
    </div>
</div>


<!-- ══════════════════════════════════════════════════════════
     MODAL — CONFIRMATION SUPPRESSION
═══════════════════════════════════════════════════════════ -->
<div class="modal-overlay" id="modal-confirm-overlay" onclick="fermerModalConfirm()">
    <div class="modal modal-sm" onclick="event.stopPropagation()">
        <h3>Confirmer la suppression</h3>
        <p>Voulez-vous vraiment supprimer <strong id="confirm-nom"></strong> ?<br>
           Cette action est irréversible.</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="fermerModalConfirm()">Annuler</button>
            <a id="confirm-lien" href="#" class="btn-confirm-delete">Supprimer</a>
        </div>
    </div>
</div>


<script>
// ── Modal Ajouter ────────────────────────────────────────────
function ouvrirModalAjout() {
    document.getElementById('modal-produit-titre').textContent = 'Ajouter un produit';
    document.getElementById('form-action').value  = 'ajouter';
    document.getElementById('form-id').value      = '';
    document.getElementById('btn-submit').textContent = 'Ajouter';
    document.getElementById('form-produit').reset();
    document.getElementById('modal-produit-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

// ── Modal Modifier ───────────────────────────────────────────
function ouvrirModalModifier(id, nom, description, prix, stock, categorie, marque, taille) {
    document.getElementById('modal-produit-titre').textContent = 'Modifier un produit';
    document.getElementById('form-action').value  = 'modifier';
    document.getElementById('form-id').value      = id;
    document.getElementById('btn-submit').textContent = 'Enregistrer';

    document.getElementById('form-nom').value          = nom;
    document.getElementById('form-description').value  = description;
    document.getElementById('form-prix').value         = prix;
    document.getElementById('form-stock').value        = stock;
    document.getElementById('form-categorie').value    = categorie;
    document.getElementById('form-marque').value       = marque;
    document.getElementById('form-taille').value       = taille;

    document.getElementById('modal-produit-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function fermerModalProduit() {
    document.getElementById('modal-produit-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

// ── Modal Suppression ────────────────────────────────────────
function confirmerSuppression(id, nom) {
    document.getElementById('confirm-nom').textContent = nom;
    document.getElementById('confirm-lien').href = '?action=supprimer&id=' + id;
    document.getElementById('modal-confirm-overlay').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function fermerModalConfirm() {
    document.getElementById('modal-confirm-overlay').classList.remove('open');
    document.body.style.overflow = '';
}

// ── Fermer avec Échap ────────────────────────────────────────
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { fermerModalProduit(); fermerModalConfirm(); }
});
</script>

</body>
</html>