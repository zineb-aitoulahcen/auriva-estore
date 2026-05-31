<?php
    require 'db.php';
    class Produit{
        // recuperer tous les produits
        public static function getAll($pdo){
            $sql = "SELECT * FROM produit";
            $pdostmt = $pdo->query($sql);
            return $pdostmt->fetch(PDO::FETCH_ASSOC);
        }
        // recuperer un produit par son id
        public static function getById($pdo,$id){
            $stmt = $pdo->prepare("SELECT * FROM produit WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        // Rechercher par catégorie
        public static function getByCategorie($pdo, $categorie) {
            $stmt = $pdo->prepare("SELECT * FROM produit WHERE categorie = ?");
            $stmt->execute([$categorie]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        // Ajouter un produit ( pour l'admin )
         public static function ajouter($pdo, $nom, $description, $prix, $stock, $categorie, $marque, $taille, $image) {
            $stmt = $pdo->prepare("INSERT INTO produit (nom, description, prix, stock, categorie, marque, taille, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $description, $prix, $stock, $categorie, $marque, $taille, $image]);
        }
        // Modifier un produit ( pour l'admin )
        public static function modifier($pdo, $id, $nom, $description, $prix, $stock, $categorie, $marque, $taille, $image) {
            $stmt = $pdo->prepare("UPDATE produit SET nom=?, description=?, prix=?, stock=?, categorie=?, marque=?, taille=?, image=? WHERE id = ?");
            $stmt->execute([$nom, $description, $prix, $stock, $categorie, $marque, $taille, $image, $id]);
        }

        // Supprimer un produit ( pour l'admin )
        public static function supprimer($pdo, $id) {
            $stmt = $pdo->prepare("DELETE FROM produit WHERE id = ?");
            $stmt->execute([$id]);
        }

    }
?>