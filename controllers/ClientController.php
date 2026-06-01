<?php
require_once '../config/session.php';
require_once '../models/Utilisateur.php';

// Protection : admin seulement
if (!estAdmin()) {
    header('Location: ../views/login.php');
    exit;
}

$message     = '';
$messageType = '';

if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // ===== AJOUTER =====
    if ($action === 'ajouter') {
        $prenom = $_POST['prenom'] ?? '';
        $nom    = $_POST['nom'] ?? '';
        $email  = $_POST['email'] ?? '';
        $tel    = $_POST['telephone'] ?? '';
        $pwd    = $_POST['mot_de_passe'] ?? '';

        if ($prenom && $nom && $email && $tel && $pwd) {
            if (Utilisateur::getUserByEmail($email)) {
                $message     = "Cet email est déjà utilisé.";
                $messageType = 'error';
            } else {
                Utilisateur::creerUtilisateur($prenom, $nom, $email, $tel, password_hash($pwd, PASSWORD_DEFAULT));
                $message     = "Client ajouté avec succès.";
                $messageType = 'success';
            }
        } else {
            $message     = "Veuillez remplir tous les champs.";
            $messageType = 'error';
        }
    }

    // ===== MODIFIER =====
    if ($action === 'modifier' && isset($_POST['id'])) {
        $id     = (int)$_POST['id'];
        $prenom = $_POST['prenom'] ?? '';
        $nom    = $_POST['nom'] ?? '';
        $email  = $_POST['email'] ?? '';
        $tel    = $_POST['telephone'] ?? '';

        if ($prenom && $nom && $email && $tel) {
            Utilisateur::modifierUtilisateur($id, $prenom, $nom, $email, $tel);
            $message     = "Client modifié avec succès.";
            $messageType = 'success';
        } else {
            $message     = "Veuillez remplir tous les champs.";
            $messageType = 'error';
        }
    }

    // ===== SUPPRIMER =====
    if ($action === 'supprimer' && isset($_POST['id'])) {
        Utilisateur::supprimerUtilisateur((int)$_POST['id']);
        $message     = "Client supprimé avec succès.";
        $messageType = 'success';
    }

    // ===== CHANGER ROLE =====
    if ($action === 'changer_role' && isset($_POST['id'], $_POST['role'])) {
        $roleValide = in_array($_POST['role'], ['client', 'admin']) ? $_POST['role'] : 'client';
        Utilisateur::changerRole((int)$_POST['id'], $roleValide);
        $message     = "Rôle mis à jour avec succès.";
        $messageType = 'success';
    }
}

// Recherche + données
$terme        = $_GET['recherche'] ?? '';
$clients      = $terme ? Utilisateur::rechercherClients($terme) : Utilisateur::getAllClients();
$total        = Utilisateur::countUtilisateurs();
$totalClients = count(array_filter($clients, fn($c) => $c['role'] === 'client'));

// Charger la vue
require_once '../views/admin/gestion_clients.php';
?>