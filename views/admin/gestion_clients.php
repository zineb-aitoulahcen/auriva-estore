<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AURIVA — Gestion Clients</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300&family=Jost:wght@300;400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/auriva-estore/assets/css/gestion_clients.css" />
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
    <div class="nav-left">
        <a href="/auriva-estore/views/accueil.php" class="logo">AURIVA</a>
        <a href="/auriva-estore/views/accueil.php" class="nav-link">Accueil</a>
        <a href="gestion_produits.php" class="nav-link">Produits</a>
        <a href="/auriva-estore/controllers/ClientController.php" class="nav-link active">Clients</a>
        <a href="statistiques.php" class="nav-link">Statistiques</a>
    </div>
    <div class="nav-right">
        <span class="admin-badge">Admin</span>
        <a href="/auriva-estore/controllers/AuthController.php?action=deconnexion" class="btn-logout">Déconnexion</a>
    </div>
</nav>

<!-- PAGE -->
<div class="page">

    <!-- EN-TÊTE -->
    <div class="page-header">
        <div class="page-title">
            Gestion des clients
            <span>Gérez les comptes clients de la boutique</span>
        </div>
        <div class="stats-row">
            <div class="stat-box">
                <span class="num"><?php echo $total; ?></span>
                <span class="lbl">Comptes</span>
            </div>
            <div class="stat-box">
                <span class="num"><?php echo $totalClients; ?></span>
                <span class="lbl">Clients</span>
            </div>
            <button class="btn-ajouter" onclick="ouvrirModalAjouter()">+ Ajouter un client</button>
        </div>
    </div>

    <!-- MESSAGE -->
    <?php if ($message) { ?>
        <div class="alert <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <!-- BARRE DE RECHERCHE -->
    <div class="toolbar">
        <form method="GET" action="/auriva-estore/controllers/ClientController.php" class="search-form">
            <input type="text" name="recherche" placeholder="Rechercher par nom ou email..." value="<?php echo $terme; ?>" />
            <button type="submit">Chercher</button>
        </form>
        <?php if ($terme) { ?>
            <a href="/auriva-estore/controllers/ClientController.php" style="font-size:13px; color:var(--text-muted); text-decoration:none;">✕ Effacer</a>
        <?php } ?>
        <span class="result-count"><?php echo count($clients); ?> résultat(s)</span>
    </div>

    <!-- TABLEAU -->
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Téléphone</th>
                    <th>Rôle</th>
                    <th>Inscription</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($clients)) { ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty">
                                <span>◌</span>
                                Aucun client trouvé.
                            </div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <?php foreach ($clients as $c) { ?>
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="avatar">
                                        <?php echo substr($c['prenom'], 0, 1); ?>
                                    </div>
                                    <div>
                                        <div class="user-name"><?php echo $c['prenom'] . ' ' . $c['nom']; ?></div>
                                        <div class="user-email"><?php echo $c['email']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $c['telephone']; ?></td>
                            <td>
                                <span class="badge badge-<?php echo $c['role']; ?>">
                                    <?php echo $c['role']; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($c['date_inscription'])); ?></td>
                            <td>
                                <div class="actions">

                                    <!-- Changer rôle -->
                                    <form method="POST" action="/auriva-estore/controllers/ClientController.php">
                                        <input type="hidden" name="action" value="changer_role">
                                        <input type="hidden" name="id" value="<?php echo $c['id']; ?>">
                                        <input type="hidden" name="role" value="<?php echo $c['role'] === 'admin' ? 'client' : 'admin'; ?>">
                                        <button type="submit" class="btn-role">
                                            <?php echo $c['role'] === 'admin' ? '→ Client' : '→ Admin'; ?>
                                        </button>
                                    </form>

                                    <!-- Modifier -->
                                    <button class="btn-edit" onclick="ouvrirModalModifier(
                                        <?php echo $c['id']; ?>,
                                        '<?php echo $c['prenom']; ?>',
                                        '<?php echo $c['nom']; ?>',
                                        '<?php echo $c['email']; ?>',
                                        '<?php echo $c['telephone']; ?>'
                                    )">Modifier</button>

                                    <!-- Supprimer (clients seulement) -->
                                    <?php if ($c['role'] === 'client') { ?>
                                        <button class="btn-delete" onclick="ouvrirModalSupprimer(
                                            <?php echo $c['id']; ?>,
                                            '<?php echo $c['prenom'] . ' ' . $c['nom']; ?>'
                                        )">Supprimer</button>
                                    <?php } ?>

                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>

<!-- MODAL : AJOUTER -->
<div class="modal-overlay" id="modalAjouter">
    <div class="modal">
        <h3>Ajouter un client</h3>
        <form method="POST" action="/auriva-estore/controllers/ClientController.php">
            <input type="hidden" name="action" value="ajouter">
            <div class="form-grid">
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" required placeholder="Prénom" />
                </div>
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" required placeholder="Nom" />
                </div>
                <div class="form-group full">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="email@exemple.com" />
                </div>
                <div class="form-group">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" required placeholder="06XXXXXXXX" />
                </div>
                <div class="form-group">
                    <label>Mot de passe</label>
                    <input type="password" name="mot_de_passe" required placeholder="••••••••" />
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="fermerTout()">Annuler</button>
                <button type="submit" class="btn-confirm">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL : MODIFIER -->
<div class="modal-overlay" id="modalModifier">
    <div class="modal">
        <h3>Modifier le client</h3>
        <form method="POST" action="/auriva-estore/controllers/ClientController.php">
            <input type="hidden" name="action" value="modifier">
            <input type="hidden" name="id" id="editId">
            <div class="form-grid">
                <div class="form-group">
                    <label>Prénom</label>
                    <input type="text" name="prenom" id="editPrenom" required />
                </div>
                <div class="form-group">
                    <label>Nom</label>
                    <input type="text" name="nom" id="editNom" required />
                </div>
                <div class="form-group full">
                    <label>Email</label>
                    <input type="email" name="email" id="editEmail" required />
                </div>
                <div class="form-group full">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" id="editTelephone" required />
                </div>
            </div>
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="fermerTout()">Annuler</button>
                <button type="submit" class="btn-confirm">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL : SUPPRIMER -->
<div class="modal-overlay" id="modalSupprimer">
    <div class="modal">
        <h3>Confirmer la suppression</h3>
        <p id="modalText">Voulez-vous vraiment supprimer ce client ?</p>
        <form method="POST" action="/auriva-estore/controllers/ClientController.php">
            <input type="hidden" name="action" value="supprimer">
            <input type="hidden" name="id" id="deleteId">
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="fermerTout()">Annuler</button>
                <button type="submit" class="btn-confirm-delete">Supprimer</button>
            </div>
        </form>
    </div>
</div>

<script>
    function fermerTout() {
        document.querySelectorAll('.modal-overlay').forEach(function(m) {
            m.classList.remove('open');
        });
    }

    function ouvrirModalAjouter() {
        fermerTout();
        document.getElementById('modalAjouter').classList.add('open');
    }

    function ouvrirModalModifier(id, prenom, nom, email, telephone) {
        fermerTout();
        document.getElementById('editId').value        = id;
        document.getElementById('editPrenom').value    = prenom;
        document.getElementById('editNom').value       = nom;
        document.getElementById('editEmail').value     = email;
        document.getElementById('editTelephone').value = telephone;
        document.getElementById('modalModifier').classList.add('open');
    }

    function ouvrirModalSupprimer(id, nom) {
        fermerTout();
        document.getElementById('deleteId').value = id;
        document.getElementById('modalText').textContent = 'Voulez-vous vraiment supprimer le compte de ' + nom + ' ? Cette action est irréversible.';
        document.getElementById('modalSupprimer').classList.add('open');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) fermerTout();
        });
    });
</script>

</body>
</html>