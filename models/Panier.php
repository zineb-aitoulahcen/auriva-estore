<?php
    class Panier {

        // Récupérer les produits du panier d'un client
        public static function getPanier($pdo, $client_id) {
            $stmt = $pdo->prepare("SELECT panier.id, panier.quantite, produit.nom, produit.marque, 
                                        produit.prix, produit.image, produit.taille
                                FROM panier 
                                JOIN produit ON panier.produit_id = produit.id
                                WHERE panier.client_id = ?");
            $stmt->execute([$client_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // Ajouter un produit au panier
        public static function ajouter($pdo, $client_id, $produit_id) {
            // Vérifier si le produit est déjà dans le panier
            $stmt = $pdo->prepare("SELECT id, quantite FROM panier 
                                WHERE client_id = ? AND produit_id = ?");
            $stmt->execute([$client_id, $produit_id]);
            $exist = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($exist) {
                // Produit déjà dans le panier → augmenter la quantité
                $stmt = $pdo->prepare("UPDATE panier SET quantite = quantite + 1 WHERE id = ?");
                $stmt->execute([$exist['id']]);
            } else {
                // Nouveau produit → insérer
                $stmt = $pdo->prepare("INSERT INTO panier (client_id, produit_id, quantite) VALUES (?, ?, 1)");
                $stmt->execute([$client_id, $produit_id]);
            }
        }

        // Modifier la quantité
        public static function modifierQuantite($pdo, $panier_id, $quantite) {
            $stmt = $pdo->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
            $stmt->execute([$quantite, $panier_id]);
        }

        // Supprimer un produit du panier
        public static function supprimer($pdo, $panier_id) {
            $stmt = $pdo->prepare("DELETE FROM panier WHERE id = ?");
            $stmt->execute([$panier_id]);
        }

        // Vider le panier d'un client
        public static function vider($pdo, $client_id) {
            $stmt = $pdo->prepare("DELETE FROM panier WHERE client_id = ?");
            $stmt->execute([$client_id]);
        }

        // Calculer le total
        public static function calculerTotal($pdo, $client_id) {
            $stmt = $pdo->prepare("SELECT SUM(panier.quantite * produit.prix)
                                FROM panier 
                                JOIN produit ON panier.produit_id = produit.id
                                WHERE panier.client_id = ?");
            $stmt->execute([$client_id]);
            return $stmt->fetchColumn() ?? 0;
        }
    }
?>