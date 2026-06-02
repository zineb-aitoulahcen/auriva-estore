<?php
require_once('../config/session.php');
require_once('../config/db.php');

// Protection : admin seulement
if (!estAdmin()) {
    header('Location: ../views/login.php');
    exit;
}

$pdo = connectToBD();

// ── Produits ──────────────────────────────────────────────────
$totalProduits = $pdo->query("SELECT COUNT(*) FROM produit")->fetchColumn();
$stockFaible   = $pdo->query("SELECT COUNT(*) FROM produit WHERE stock <= 5")->fetchColumn();
$produitsParCategorie = $pdo->query("SELECT categorie, COUNT(*) as total FROM produit GROUP BY categorie")->fetchAll(PDO::FETCH_ASSOC);

// ── Clients ───────────────────────────────────────────────────
$totalClients  = $pdo->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'client'")->fetchColumn();
$totalAdmins   = $pdo->query("SELECT COUNT(*) FROM utilisateur WHERE role = 'admin'")->fetchColumn();
$totalComptes  = $pdo->query("SELECT COUNT(*) FROM utilisateur")->fetchColumn();

// ── Commandes ─────────────────────────────────────────────────
$totalCommandes  = $pdo->query("SELECT COUNT(*) FROM commande")->fetchColumn();
$chiffreAffaires = $pdo->query("SELECT COALESCE(SUM(montant_total), 0) FROM commande WHERE statut = 'livree'")->fetchColumn();

$commandesParStatut = $pdo->query("SELECT statut, COUNT(*) as total FROM commande GROUP BY statut")->fetchAll(PDO::FETCH_ASSOC);

// Top 5 produits les plus commandés
$topProduits = $pdo->query("
    SELECT produit.nom, SUM(commande.quantite) as total_vendu
    FROM commande
    JOIN produit ON commande.produit_id = produit.id
    WHERE commande.statut != 'annulee'
    GROUP BY produit.id, produit.nom
    ORDER BY total_vendu DESC
    LIMIT 5
")->fetchAll(PDO::FETCH_ASSOC);

// Dernières commandes
$dernieresCommandes = $pdo->query("
    SELECT commande.id, commande.montant_total, commande.statut, commande.date_commande,
           utilisateur.nom, utilisateur.prenom, produit.nom as produit_nom
    FROM commande
    JOIN utilisateur ON commande.client_id = utilisateur.id
    JOIN produit ON commande.produit_id = produit.id
    ORDER BY commande.date_commande DESC
    LIMIT 8
")->fetchAll(PDO::FETCH_ASSOC);

// ── Visites ───────────────────────────────────────────────────
$totalVisites      = $pdo->query("SELECT COUNT(*) FROM visite")->fetchColumn();
$visitesAujourdhui = $pdo->query("SELECT COUNT(*) FROM visite WHERE DATE(date_visite) = CURDATE()")->fetchColumn();

require_once('../views/admin/statistiques.php');
?>