<?php
session_start();
require_once '../config/db.php';
require_once '../models/Commande.php';

$pdo = connectToBD();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Changer le statut (admin)
if ($action === 'modifier_statut') {
    $id     = $_POST['id']     ?? '';
    $statut = $_POST['statut'] ?? '';
    Commande::modifierStatut($pdo, $id, $statut);
    header('Location: /auriva-estore/controllers/CommandeController.php');
    exit;
}

// Récupérer toutes les commandes
$commandes = Commande::getAll($pdo);
require '../views/admin/commande.php';
?>