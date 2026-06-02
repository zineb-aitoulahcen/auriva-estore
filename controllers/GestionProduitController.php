<?php
require_once('../config/session.php');
require_once('../models/Produit.php');

// Protection : admin seulement
if (!estAdmin()) {
    header('Location: ../views/login.php');
    exit;
}

$message     = '';
$messageType = '';

// ── AJOUTER ──────────────────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'ajouter') {
    $nom         = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix        = floatval($_POST['prix']);
    $stock       = intval($_POST['stock']);
    $categorie   = $_POST['categorie'];
    $marque      = trim($_POST['marque']);
    $taille      = trim($_POST['taille']);
    $image       = '';

    // Upload image
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext           = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $nomFichier    = uniqid('produit_') . '.' . $ext;
        $dossier       = '../assets/images/produits/';
        if (!is_dir($dossier)) mkdir($dossier, 0777, true);
        move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nomFichier);
        $image = 'assets/images/produits/' . $nomFichier;
    }

    Produit::ajouter($nom, $description, $prix, $stock, $categorie, $marque, $taille, $image);
    $message     = 'Produit ajouté avec succès.';
    $messageType = 'success';
}

// ── MODIFIER ─────────────────────────────────────────────────────────────────
if (isset($_POST['action']) && $_POST['action'] === 'modifier') {
    $id          = intval($_POST['id']);
    $nom         = trim($_POST['nom']);
    $description = trim($_POST['description']);
    $prix        = floatval($_POST['prix']);
    $stock       = intval($_POST['stock']);
    $categorie   = $_POST['categorie'];
    $marque      = trim($_POST['marque']);
    $taille      = trim($_POST['taille']);

    // Garder l'ancienne image par défaut
    $produitExistant = Produit::getById($id);
    $image           = $produitExistant['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $ext        = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $nomFichier = uniqid('produit_') . '.' . $ext;
        $dossier    = '../assets/images/produits/';
        if (!is_dir($dossier)) mkdir($dossier, 0777, true);
        move_uploaded_file($_FILES['image']['tmp_name'], $dossier . $nomFichier);
        $image = 'assets/images/produits/' . $nomFichier;
    }

    Produit::modifier($id, $nom, $description, $prix, $stock, $categorie, $marque, $taille, $image);
    $message     = 'Produit modifié avec succès.';
    $messageType = 'success';
}

// ── SUPPRIMER ────────────────────────────────────────────────────────────────
if (isset($_GET['action']) && $_GET['action'] === 'supprimer' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Produit::supprimer($id);
    $message     = 'Produit supprimé avec succès.';
    $messageType = 'success';
}

// ── DONNÉES pour la vue ───────────────────────────────────────────────────────
$terme = '';
if (isset($_GET['recherche'])) {
    $terme = $_GET['recherche'];
}

if ($terme) {
    $produits = Produit::rechercherProduits($terme);
} else {
    $produits = Produit::getAll();
}

$totalProduits = Produit::countProduits();

// Produit à modifier (pour pré-remplir le modal)
$produitModif = null;
if (isset($_GET['modifier'])) {
    $produitModif = Produit::getById(intval($_GET['modifier']));
}

require_once('../views/admin/gestion_produits.php');
?>