<?php
session_start();
require_once('../config/db.php');

$action = $_POST['action'] ?? '';

// ===== CONNEXION =====
if($action === 'connexion') {

    $email = $_POST['email'] ?? '';
    $pwd   = $_POST['pwd']   ?? '';

    try {
        $pdo = connectToBD();

        $sql = "SELECT COUNT(*) FROM utilisateurs 
                WHERE email = :email 
                AND mot_de_passe = :pwd";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'email' => $email,
            'pwd'   => $pwd
        ]);

        $nbrLigne = $stmt->fetchColumn(0);

        if($nbrLigne == 1) {
            $_SESSION['user']  = true;
            $_SESSION['email'] = $email;
            header('Location: ../views/accueil.php');
        } else {
            $_SESSION['erreur'] = "Email ou mot de passe incorrect.";
            header('Location: ../views/login.php');
        }

    } catch(PDOException $e) {
        die('Erreur : ' . $e->getMessage());
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
        $_SESSION['erreur'] = "Les mots de passe ne correspondent pas.";
        header('Location: ../views/register.php');
        exit;
    }

    try {
        $pdo = connectToBD();

        $sql = "INSERT INTO utilisateurs (prenom, nom, email, telephone, mot_de_passe)
                VALUES (:prenom, :nom, :email, :tel, :pwd)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'prenom' => $prenom,
            'nom'    => $nom,
            'email'  => $email,
            'tel'    => $tel,
            'pwd'    => $pwd
        ]);

        $_SESSION['succes'] = "Compte créé avec succès ! Connectez-vous.";
        header('Location: ../views/login.php');

    } catch(PDOException $e) {
        $_SESSION['erreur'] = "Cet email est déjà utilisé.";
        header('Location: ../views/register.php');
    }
    exit;
}
?>