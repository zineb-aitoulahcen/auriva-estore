<?php
    class Commande {

        // Créer une commande
        public static function creer($pdo, $client_id, $produit_id, $quantite, $prix_unitaire, $montant_total) {
            $stmt = $pdo->prepare("INSERT INTO commande (client_id, produit_id, quantite, prix_unitaire, montant_total, statut) 
                                VALUES (?, ?, ?, ?, ?, 'en attente')");
            $stmt->execute([$client_id, $produit_id, $quantite, $prix_unitaire, $montant_total]);
        }

        // Récupérer les commandes d'un client
        public static function getByClient($pdo, $client_id) {
            $stmt = $pdo->prepare("SELECT commande.*, produit.nom, produit.image 
                                FROM commande 
                                JOIN produit ON commande.produit_id = produit.id
                                WHERE commande.client_id = ?
                                ORDER BY commande.date_commande DESC");
            $stmt->execute([$client_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Récupérer une commande par son id
        public static function getById($pdo, $id) {
            $stmt = $pdo->prepare("SELECT commande.*, produit.nom, produit.image 
                                FROM commande 
                                JOIN produit ON commande.produit_id = produit.id
                                WHERE commande.id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Modifier le statut (admin)
        public static function modifierStatut($pdo, $id, $statut) {
            $stmt = $pdo->prepare("UPDATE commande SET statut = ? WHERE id = ?");
            $stmt->execute([$statut, $id]);
        }

        // Récupérer toutes les commandes (admin)
        public static function getAll($pdo) {
            $stmt = $pdo->query("SELECT commande.*, utilisateur.nom, utilisateur.prenom, produit.nom as produit_nom
                                FROM commande 
                                JOIN utilisateur ON commande.client_id = utilisateur.id
                                JOIN produit ON commande.produit_id = produit.id
                                ORDER BY commande.date_commande DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>