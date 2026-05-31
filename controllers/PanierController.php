<?php
     <?php
session_start();
require '../config/db.php';
require '../models/Panier.php';

$action    = $_POST['action'] ?? '';
$client_id = $_SESSION['user']['id'];

// ===== AJOUTER =====
if ($action === 'ajouter') {
    $produit_id = $_POST['produit_id'];
    Panier::ajouter($pdo, $client_id, $produit_id);
    header('Location: ../views/accueil.php');
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
    // À compléter quand on fera la partie commande
    header('Location: ../views/panier.php');
    exit;
}
?>
?>