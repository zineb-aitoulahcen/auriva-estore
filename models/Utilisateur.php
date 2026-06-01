<?php
require_once('../config/db.php');

class Utilisateur {

    // ===== Chercher user par email =====
    public static function getUserByEmail($email) {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===== Créer user =====
    public static function creerUtilisateur($prenom, $nom, $email, $tel, $pwd) {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("INSERT INTO utilisateur (prenom, nom, email, telephone, mot_de_passe)
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$prenom, $nom, $email, $tel, $pwd]);
    }

    // ===== Compter users =====
    public static function countUtilisateurs() {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur");
        $stmt->execute();
        return $stmt->fetchColumn(0);
    }

    // ===== Lister tous les utilisateurs =====
    public static function getAllClients() {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur ORDER BY date_inscription DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ===== Chercher user par ID =====
    public static function getUserById($id) {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===== Modifier les infos d'un client =====
    public static function modifierUtilisateur($id, $prenom, $nom, $email, $telephone) {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("UPDATE utilisateur 
                               SET prenom = ?, nom = ?, email = ?, telephone = ?
                               WHERE id = ?");
        $stmt->execute([$prenom, $nom, $email, $telephone, $id]);
    }

    // ===== Supprimer un client =====
    public static function supprimerUtilisateur($id) {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id = ? AND role = 'client'");
        $stmt->execute([$id]);
    }

    // ===== Changer le rôle =====
    public static function changerRole($id, $role) {
        $pdo = connectToBD();
        $stmt = $pdo->prepare("UPDATE utilisateur SET role = ? WHERE id = ?");
        $stmt->execute([$role, $id]);
    }

    // ===== Rechercher par nom/email =====
    public static function rechercherClients($terme) {
        $pdo = connectToBD();
        $like = '%' . $terme . '%';
        $stmt = $pdo->prepare("SELECT * FROM utilisateur 
                               WHERE (nom LIKE ? OR prenom LIKE ? OR email LIKE ?)
                               ORDER BY date_inscription DESC");
        $stmt->execute([$like, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>