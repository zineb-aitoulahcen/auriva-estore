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
        public static function filtrer($recherche = null, $categorie = null, $marque = null, $prix_max = null, $famille = null, $taille = null, $genre = null, $tri = null) {
        $pdo = connectToBD();
        $sql = "SELECT * FROM produit WHERE 1=1";
        $params = [];

        if (!empty($recherche)) {
            $sql .= " AND (nom LIKE ? OR marque LIKE ?)";
            $params[] = "%$recherche%";
            $params[] = "%$recherche%";
        }
        if (!empty($categorie)) {
            $sql .= " AND categorie = ?";
            $params[] = $categorie;
        }
        if (!empty($marque)) {
            $sql .= " AND marque = ?";
            $params[] = $marque;
        }
        if (!empty($prix_max)) {
            $sql .= " AND prix <= ?";
            $params[] = $prix_max;
        }
        if (!empty($famille)) {
            $sql .= " AND famille = ?";
            $params[] = $famille;
        }
        if (!empty($taille)) {
            $sql .= " AND taille = ?";
            $params[] = $taille;
        }
    
        if ($tri === 'prix-asc') $sql .= " ORDER BY prix ASC";
        elseif ($tri === 'prix-desc') $sql .= " ORDER BY prix DESC";
        elseif ($tri === 'nouveau') $sql .= " ORDER BY id DESC";
        else $sql .= " ORDER BY id DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    }
?>