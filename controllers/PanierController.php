<?php
    session_start(); // Démarrer la session pour accéder à $_SESSION
    require '../config/db.php';
    require '../models/Panier.php';
    require '../config/session.php';
    $pdo = connectToBD();
    $action    = $_POST['action'] ?? '';
    $client_id = $_SESSION['user']['id'];

    // ===== AJOUTER =====
    if ($action === 'ajouter') {
        requireConnexion();
        $produit_id = $_POST['produit_id'];
        Panier::ajouter($pdo, $client_id, $produit_id);
        header('Location: ../controllers/ProduitController.php');
        exit;
    }

    // ===== MODIFIER QUANTITE =====
    if ($action === 'modifier') {
        $panier_id = $_POST['panier_id'];
        $sens      = $_POST['sens'];

        // Récupérer la quantité actuelle
        $stmt = $pdo->prepare("SELECT quantite FROM panier WHERE id = ?");
        $stmt->execute([$panier_id]);
        $quantite = $stmt->fetchColumn();

        if ($sens === 'plus') {
            $quantite++;
        } elseif ($sens === 'moins' && $quantite > 1) {
            $quantite--;
        } elseif ($sens === 'moins' && $quantite == 1) {
            // Si quantité = 1 et on clique moins → supprimer
            Panier::supprimer($pdo, $panier_id);
            header('Location: ../views/panier.php');
            exit;
        }

        Panier::modifierQuantite($pdo, $panier_id, $quantite);
        header('Location: ../views/panier.php');
        exit;
    }

    // ===== SUPPRIMER =====
    if ($action === 'supprimer') {
        $panier_id = $_POST['panier_id'];
        Panier::supprimer($pdo, $panier_id);
        header('Location: ../views/panier.php');
        exit;
    }

    // ===== VIDER =====
    if ($action === 'vider') {
        Panier::vider($pdo, $client_id);
        header('Location: ../views/panier.php');
        exit;
    }

   // ===== VALIDER COMMANDE =====
if ($action === 'valider') {
    $produits = Panier::getPanier($pdo, $client_id);

    if (empty($produits)) {
        header('Location: ../views/panier.php');
        exit;
    }

    $stmt = $pdo->prepare("
        INSERT INTO commande (client_id, produit_id, quantite, prix_unitaire, montant_total)
        VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($produits as $p) {
        $montant = $p['prix'] * $p['quantite'];
        $stmt->execute([
            $client_id,
            $p['produit_id'],
            $p['quantite'],
            $p['prix'],
            $montant
        ]);
    }

    // Récupérer l'id de la dernière commande insérée
    $derniere_commande_id = $pdo->lastInsertId();

    Panier::vider($pdo, $client_id);

    header('Location: ../views/suivi_commande.php?commande_id=' . $derniere_commande_id);
    exit;
}
?>