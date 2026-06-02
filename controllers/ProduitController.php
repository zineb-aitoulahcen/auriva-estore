<?php
session_start();
require_once '../config/db.php';
require_once '../models/Produit.php';
require_once '../models/Panier.php';

$pdo = connectToBD();

// Enregistrer la visite
$stmt = $pdo->prepare("INSERT INTO visite (page) VALUES (?)");
$stmt->execute(['accueil']);

// Récupérer les filtres depuis GET
$recherche  = isset($_GET['recherche'])  ? ($_GET['recherche'])  : null;
$categorie  = isset($_GET['categorie'])  ? ($_GET['categorie'])  : null;
$marque     = isset($_GET['marque'])     ? ($_GET['marque'])     : null;
$prix_max   = isset($_GET['prix_max'])   ? ($_GET['prix_max'])   : null;
$famille    = isset($_GET['famille'])    ? ($_GET['famille'])    : null;
$taille     = isset($_GET['taille'])     ? ($_GET['taille'])     : null;
$genre      = isset($_GET['genre'])      ? ($_GET['genre'])      : null;
$tri        = isset($_GET['tri'])        ? ($_GET['tri'])        : 'nouveau';

// Appel unique avec tous les filtres
$produits = Produit::filtrer($recherche, $categorie, $marque, $prix_max, $famille, $taille, $genre, $tri);

require '../views/accueil.php';
?>