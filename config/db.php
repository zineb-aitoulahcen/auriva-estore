<?php
function connectToBD() {
    try {
        $cnx = new PDO("mysql:host=localhost;dbname=auriva;charset=utf8", "root", "aya123");
        return $cnx;
    } catch(PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
    }
}
?>