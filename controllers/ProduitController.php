<?php
session_start();
require '../config/db.php';
require '../models/Produit.php';

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