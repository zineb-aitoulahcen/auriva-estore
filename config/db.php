<?php
// Chaque fois on est besoin de la BD , in iclu ce fichier et on utilise conectToBD()
   function connectToBD(){
    try{
        $cnx = new PDO("mysql:host=localhost;dbname=auriva","root","aya123");
        return $cnx;
    }catch(PDOException $e){
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
   }
?>