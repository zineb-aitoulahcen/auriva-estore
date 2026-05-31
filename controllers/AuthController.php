<?php
session_start();
require('../config/db.php');
require('../models/Utilisateur.php'); 

$action = $_POST['action'] ?? '';

// ===== CONNEXION =====
if($action === 'connexion') {

    $email = $_POST['email'] ?? '';
    $pwd   = $_POST['pwd']   ?? '';

    
    $user = getUserByEmail($email);

    if($user && $user['mot_de_passe'] === $pwd) {
        $_SESSION['user']  = true;
        $_SESSION['email'] = $email;
        header('Location: ../views/accueil.php');
    } else {
        die("Email ou mot de passe incorrect");
    }
    exit;
}

// ===== INSCRIPTION =====
if($action === 'inscription') {

    $prenom  = $_POST['prenom']      ?? '';
    $nom     = $_POST['nom']         ?? '';
    $email   = $_POST['email']       ?? '';
    $tel     = $_POST['telephone']   ?? '';
    $pwd     = $_POST['pwd']         ?? '';
    $confirm = $_POST['confirm_pwd'] ?? '';

    if($pwd !== $confirm) {
        die("Les mots de passe ne correspondent pas");
    }


    $userExiste = getUserByEmail($email);
    if($userExiste) {
        die("Cet email est deja utilise");
    }

    
    creerUtilisateur($prenom, $nom, $email, $tel, $pwd);
    header('Location: ../views/login.php');
    exit;
}
?>