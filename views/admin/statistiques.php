<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AURIVA — Statistiques</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/auriva-estore/assets/css/statistiques.css">
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar">
    <div class="nav-left">
        <a href="../views/accueil.php" class="logo">AURIVA</a>
        <a href="../views/accueil.php"                          class="nav-link">Accueil</a>
        <a href="../controllers/ProduitController.php"          class="nav-link">Produits</a>
        <a href="../controllers/ClientController.php"           class="nav-link">Clients</a>
        <a href="/auriva-estore/controllers/CommandeController.php" class="nav-link">Commandes</a>
        <a href="../controllers/StatistiquesController.php"     class="nav-link active">Statistiques</a>
    </div>
    <div class="nav-right">
        <span class="admin-badge">Admin</span>
        <a href="../controllers/AuthController.php?action=deconnexion" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<div class="page">

    <!-- ── EN-TÊTE ── -->
    <div class="page-header">
        <div class="page-title">
            Statistiques
            <span>Vue d'ensemble de la boutique Auriva</span>
        </div>
    </div>

    <!-- ══════════════════════════════════════════════════════
         SECTION 1 — CHIFFRES CLÉS
    ═══════════════════════════════════════════════════════ -->
    <div class="kpi-grid">

        <div class="kpi-card">
            <div class="kpi-icon">🧴</div>
            <div class="kpi-info">
                <span class="kpi-num"><?= $totalProduits ?></span>
                <span class="kpi-lbl">Produits en catalogue</span>
            </div>
        </div>

        <div class="kpi-card <?= $stockFaible > 0 ? 'kpi-warn' : '' ?>">
            <div class="kpi-icon">⚠️</div>
            <div class="kpi-info">
                <span class="kpi-num"><?= $stockFaible ?></span>
                <span class="kpi-lbl">Stocks faibles (≤ 5)</span>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon">👥</div>
            <div class="kpi-info">
                <span class="kpi-num"><?= $totalClients ?></span>
                <span class="kpi-lbl">Clients inscrits</span>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon">📦</div>
            <div class="kpi-info">
                <span class="kpi-num"><?= $totalCommandes ?></span>
                <span class="kpi-lbl">Commandes totales</span>
            </div>
        </div>

        <div class="kpi-card kpi-gold">
            <div class="kpi-icon">💰</div>
            <div class="kpi-info">
                <span class="kpi-num"><?= number_format($chiffreAffaires, 0, ',', ' ') ?> MAD</span>
                <span class="kpi-lbl">Chiffre d'affaires (livrées)</span>
            </div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon">👁️</div>
            <div class="kpi-info">
                <span class="kpi-num"><?= $totalVisites ?></span>
                <span class="kpi-lbl">Visites totales</span>
            </div>
        </div>

    </div>

    <!-- ══════════════════════════════════════════════════════
         SECTION 2 — COMMANDES & PRODUITS
    ═══════════════════════════════════════════════════════ -->
    <div class="stats-row-2">

        <!-- Commandes par statut -->
        <div class="stats-block">
            <h2 class="block-title">Commandes par statut</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Statut</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($commandesParStatut)): ?>
                        <tr><td colspan="2" class="empty">Aucune commande.</td></tr>
                    <?php else: ?>
                        <?php foreach ($commandesParStatut as $row): ?>
                        <tr>
                            <td>
                                <span class="badge badge-statut badge-<?= str_replace(' ', '-', $row['statut']) ?>">
                                    <?= htmlspecialchars($row['statut']) ?>
                                </span>
                            </td>
                            <td><strong><?= $row['total'] ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Produits par catégorie -->
        <div class="stats-block">
            <h2 class="block-title">Produits par catégorie</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Catégorie</th>
                            <th>Nombre</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($produitsParCategorie)): ?>
                        <tr><td colspan="2" class="empty">Aucun produit.</td></tr>
                    <?php else: ?>
                        <?php foreach ($produitsParCategorie as $row): ?>
                        <tr>
                            <td>
                                <span class="badge badge-<?= $row['categorie'] ?>">
                                    <?= htmlspecialchars($row['categorie']) ?>
                                </span>
                            </td>
                            <td><strong><?= $row['total'] ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top 5 produits -->
        <div class="stats-block">
            <h2 class="block-title">Top 5 — produits commandés</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Produit</th>
                            <th>Vendus</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (empty($topProduits)): ?>
                        <tr><td colspan="3" class="empty">Aucune vente.</td></tr>
                    <?php else: ?>
                        <?php foreach ($topProduits as $i => $row): ?>
                        <tr>
                            <td class="rank"><?= $i + 1 ?></td>
                            <td><?= htmlspecialchars($row['nom']) ?></td>
                            <td><strong><?= $row['total_vendu'] ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ══════════════════════════════════════════════════════
         SECTION 3 — DERNIÈRES COMMANDES
    ═══════════════════════════════════════════════════════ -->
    <div class="section-block">
        <h2 class="block-title">Dernières commandes</h2>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Produit</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($dernieresCommandes)): ?>
                    <tr><td colspan="6" class="empty">Aucune commande.</td></tr>
                <?php else: ?>
                    <?php foreach ($dernieresCommandes as $c): ?>
                    <tr>
                        <td class="text-muted">#<?= $c['id'] ?></td>
                        <td><?= htmlspecialchars($c['prenom'] . ' ' . $c['nom']) ?></td>
                        <td><?= htmlspecialchars($c['produit_nom']) ?></td>
                        <td class="prix"><?= number_format($c['montant_total'], 2) ?> MAD</td>
                        <td>
                            <span class="badge badge-statut badge-<?= str_replace(' ', '-', $c['statut']) ?>">
                                <?= htmlspecialchars($c['statut']) ?>
                            </span>
                        </td>
                        <td class="text-muted"><?= date('d/m/Y', strtotime($c['date_commande'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- fin .page -->

</body>
</html>