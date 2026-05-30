-- =============================================
-- TABLES : auriva_db
-- Projet : Auriva E-Store
-- Créer d'abord la BD "auriva_db" dans phpMyAdmin
-- ensuite importer ce fichier
-- =============================================

-- TABLE : utilisateur
CREATE TABLE utilisateur (
    id              INT AUTO_INCREMENT PRIMARY KEY,
    nom             VARCHAR(50) NOT NULL,
    prenom          VARCHAR(50) NOT NULL,
    email           VARCHAR(100) NOT NULL UNIQUE,
    telephone       VARCHAR(15) NOT NULL UNIQUE,
    mot_de_passe    VARCHAR(255) NOT NULL,
    role            ENUM('client', 'admin') DEFAULT 'client',
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- TABLE : produit
CREATE TABLE produit (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    description TEXT,
    prix        DECIMAL(10,2) NOT NULL,
    stock       INT DEFAULT 0,
    categorie   ENUM('homme', 'femme', 'mixte') NOT NULL,
    marque      VARCHAR(50),
    taille      VARCHAR(20),
    image       VARCHAR(255)
);

-- TABLE : panier
CREATE TABLE panier (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    client_id   INT NOT NULL,
    produit_id  INT NOT NULL,
    quantite    INT DEFAULT 1,
    FOREIGN KEY (client_id)  REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id)     ON DELETE CASCADE
);

-- TABLE : commande
CREATE TABLE commande (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    client_id     INT NOT NULL,
    produit_id    INT NOT NULL,
    quantite      INT NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    montant_total DECIMAL(10,2) NOT NULL,
    statut        ENUM('en attente', 'en preparation', 'en livraison', 'livree', 'annulee') DEFAULT 'en attente',
    date_commande DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id)  REFERENCES utilisateur(id) ON DELETE CASCADE,
    FOREIGN KEY (produit_id) REFERENCES produit(id) ON DELETE CASCADE
);

-- TABLE : visite
CREATE TABLE visite (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    page        VARCHAR(100),
    adresse_ip  VARCHAR(45),
    date_visite DATETIME DEFAULT CURRENT_TIMESTAMP
);