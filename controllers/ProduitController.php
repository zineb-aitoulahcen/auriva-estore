<?php
session_start();
require_once '../config/db.php';
require_once '../models/Produit.php';
require_once '../models/Panier.php';
$pdo = connectToBD();
// Récupérer la catégorie si filtre appliqué
$categorie = isset($_GET['categorie']) ? $_GET['categorie'] : null;

// Récupérer les produits
if ($categorie) {
    $produits = Produit::getByCategorie($pdo, $categorie);
} else {
    $produits = Produit::getAll($pdo);
}

// Envoyer les produits à la vue
require '../views/accueil.php';
?>