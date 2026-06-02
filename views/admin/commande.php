<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Auriva — Commandes</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --gold: #B8860B; --gold-pale: #F5F0E8; --border: #E0D9CC;
      --text: #1a1a1a; --text-muted: #6b6b6b; --radius: 8px;
    }
    body { font-family: 'Jost', sans-serif; font-weight: 300; background: #FAFAF8; color: var(--text); }

    /* navbar simple */
    .navbar {
      display: flex; align-items: center; justify-content: space-between;
      padding: 0 2rem; height: 60px; background: #fff;
      border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 100;
    }
    .logo { font-family: 'Cormorant Garamond', serif; font-size: 22px; font-weight: 600; color: var(--gold); letter-spacing: 3px; text-decoration: none; }
    .nav-link { font-size: 13px; color: var(--text-muted); text-decoration: none; margin-left: 1.5rem; }
    .nav-link:hover { color: var(--gold); }
    .nav-link.active { color: var(--gold); border-bottom: 1.5px solid var(--gold); padding-bottom: 2px; }

    /* contenu */
    .container { max-width: 1100px; margin: 2rem auto; padding: 0 2rem; }
    h1 { font-family: 'Cormorant Garamond', serif; font-size: 28px; font-weight: 500; margin-bottom: 0.3rem; }
    .subtitle { font-size: 13px; color: var(--text-muted); margin-bottom: 2rem; }

    table { width: 100%; border-collapse: collapse; background: #fff; border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    thead { background: var(--gold-pale); }
    th { padding: 12px 16px; font-size: 12px; font-weight: 500; letter-spacing: 1px; color: var(--text-muted); text-align: left; }
    td { padding: 12px 16px; font-size: 13px; border-top: 1px solid var(--border); vertical-align: middle; }
    tr:hover td { background: #fdfcf9; }

    /* badge statut */
    .badge {
      display: inline-block; padding: 3px 10px; border-radius: 20px;
      font-size: 11px; font-weight: 500; letter-spacing: 0.5px;
    }
    .badge-attente  { background: #FFF3CD; color: #856404; }
    .badge-confirmee { background: #D1ECF1; color: #0C5460; }
    .badge-livree   { background: #D4EDDA; color: #155724; }
    .badge-annulee  { background: #F8D7DA; color: #721C24; }

    /* select statut */
    .statut-form { display: flex; align-items: center; gap: 8px; }
    .statut-select {
      padding: 6px 10px; border: 1px solid var(--border); border-radius: var(--radius);
      font-size: 12px; font-family: 'Jost', sans-serif; background: #fff;
      color: var(--text); cursor: pointer;
    }
    .statut-select:focus { outline: none; border-color: var(--gold); }
    .btn-save {
      padding: 6px 14px; background: var(--gold); color: #fff; border: none;
      border-radius: var(--radius); font-size: 12px; font-family: 'Jost', sans-serif;
      cursor: pointer; transition: background 0.2s;
    }
    .btn-save:hover { background: #8B6508; }
  </style>
</head>
<body>

<nav class="navbar">
  <a href="/auriva-estore/controllers/ProduitController.php" class="logo">AURIVA</a>
  <div>
    <a href="/auriva-estore/controllers/ProduitController.php" class="nav-link">Accueil</a>
    <a href="/auriva-estore/controllers/GestionProduitController.php" class="nav-link">Produits</a>
    <a href="/auriva-estore/controllers/ClientController.php" class="nav-link">Clients</a>
    <a href="/auriva-estore/controllers/CommandeController.php" class="nav-link active">Commandes</a>
    <a href="/auriva-estore/controllers/StatistiquesController.php" class="nav-link">Statistiques</a>
    <a href="/auriva-estore/controllers/AuthController.php?action=deconnexion" class="nav-link">Déconnexion</a>
  </div>
</nav>

<div class="container">
  <h1>Commandes</h1>
  <p class="subtitle">Gérez et mettez à jour le statut des commandes clients</p>

  <table>
    <thead>
      <tr>
        <th>#</th>
        <th>Client</th>
        <th>Produit</th>
        <th>Qté</th>
        <th>Total</th>
        <th>Date</th>
        <th>Statut actuel</th>
        <th>Changer statut</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($commandes)): ?>
        <tr><td colspan="8" style="text-align:center;color:var(--text-muted);padding:2rem;">Aucune commande.</td></tr>
      <?php else: ?>
        <?php foreach ($commandes as $c): ?>
        <tr>
          <td>#<?= $c['id'] ?></td>
          <td><?= $c['prenom'] ?> <?= $c['nom'] ?></td>
          <td><?= $c['produit_nom'] ?></td>
          <td><?= $c['quantite'] ?></td>
          <td><?= number_format($c['montant_total'], 2) ?> MAD</td>
          <td><?= date('d/m/Y', strtotime($c['date_commande'])) ?></td>
          <td>
            <?php
              $badge = match($c['statut']) {
                'confirmée'  => 'badge-confirmee',
                'livrée'     => 'badge-livree',
                'annulée'    => 'badge-annulee',
                default      => 'badge-attente'
              };
            ?>
            <span class="badge <?= $badge ?>"><?= $c['statut'] ?></span>
          </td>
          <td>
            <form method="POST" action="/auriva-estore/controllers/CommandeController.php" class="statut-form">
              <input type="hidden" name="action" value="modifier_statut">
              <input type="hidden" name="id" value="<?= $c['id'] ?>">
              <select name="statut" class="statut-select">
                <option value="en attente"  <?= $c['statut']==='en attente'  ? 'selected' : '' ?>>En attente</option>
                <option value="confirmée"   <?= $c['statut']==='confirmée'   ? 'selected' : '' ?>>Confirmée</option>
                <option value="livrée"      <?= $c['statut']==='livrée'      ? 'selected' : '' ?>>Livrée</option>
                <option value="annulée"     <?= $c['statut']==='annulée'     ? 'selected' : '' ?>>Annulée</option>
              </select>
              <button type="submit" class="btn-save">Sauvegarder</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>