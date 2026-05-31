<?php
require_once('../config/db.php');

// ===== Chercher user par email =====
function getUserByEmail($email) {
    $pdo = connectToBD();
    
    $sql = "SELECT * FROM utilisateur 
            WHERE email = :email";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['email' => $email]);
    
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// ===== Créer user jdid =====
function creerUtilisateur($prenom, $nom, $email, $tel, $pwd) {
    $pdo = connectToBD();
    
    $sql = "INSERT INTO utilisateur (prenom, nom, email, telephone, mot_de_passe)
            VALUES (:prenom, :nom, :email, :tel, :pwd)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'prenom' => $prenom,
        'nom'    => $nom,
        'email'  => $email,
        'tel'    => $tel,
        'pwd'    => $pwd
    ]);
}

// ===== Compter users =====
function countUtilisateurs() {
    $pdo = connectToBD();
    
    $sql = "SELECT COUNT(*) FROM utilisateur";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    return $stmt->fetchColumn(0);
}
?>