<?php
session_start();

function estConnecte() {
    return isset($_SESSION['user']);
}

function estAdmin() {
    return isset($_SESSION['user']) 
           && $_SESSION['user']['role'] === 'admin';
}

function requireConnexion() {
    if(!estConnecte()) {
        header('Location: /auriva-estore/views/login.php');
        exit;
    }
}
?>