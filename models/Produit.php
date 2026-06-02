<?php
    require_once('../config/db.php');
    class Produit{
        // recuperer tous les produits
        public static function getAll(){
            $pdo = connectToBD();
            $sql = "SELECT * FROM produit";
            $pdostmt = $pdo->query($sql);
            return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // recuperer un produit par son id
        public static function getById($id){
            $pdo = connectToBD();
            $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        // Rechercher par nom 
        public static function rechercherProduits($terme) {
            $pdo = connectToBD();
            $stmt = $pdo->prepare("SELECT * FROM produit WHERE nom LIKE ?");
            $stmt->execute(["%$terme%"]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Rechercher par catégorie
        public static function getByCategorie($categorie) {
            $pdo = connectToBD();
            $stmt = $pdo->prepare("SELECT * FROM produit WHERE categorie = ?");
            $stmt->execute([$categorie]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // compter le nombre de produits
        public static function countProduits() {
            $pdo = connectToBD();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM produit");
            $stmt->execute();
            return $stmt->fetchColumn(0);
        }
        // Ajouter un produit ( pour l'admin )
         public static function ajouter($nom, $description, $prix, $stock, $categorie, $marque, $taille, $image) {
            $pdo = connectToBD();
            $stmt = $pdo->prepare("INSERT INTO produit (nom, description, prix, stock, categorie, marque, taille, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $description, $prix, $stock, $categorie, $marque, $taille, $image]);
        }
        // Modifier un produit ( pour l'admin )
        public static function modifier($id, $nom, $description, $prix, $stock, $categorie, $marque, $taille, $image) {
            $pdo = connectToBD();
            $stmt = $pdo->prepare("UPDATE produit SET nom=?, description=?, prix=?, stock=?, categorie=?, marque=?, taille=?, image=? WHERE id = ?");
            $stmt->execute([$nom, $description, $prix, $stock, $categorie, $marque, $taille, $image, $id]);
        }

        // Supprimer un produit ( pour l'admin )
        public static function supprimer($id) {
            $pdo = connectToBD();
            $stmt = $pdo->prepare("DELETE FROM produit WHERE id = ?");
            $stmt->execute([$id]);
        }

    }
?>