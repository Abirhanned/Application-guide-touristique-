<?php

require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_login'])) {
    header('Location: index.php');
    exit();
}

// Chargement de Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// Définir la page active
$pageActive = 'accueil'; 

// Variables de session
$user_login = $_SESSION['user_login'] ?? null;
$user_role = $_SESSION['user_role'] ?? null;



// Affichage du template
echo $twig->render('accueil.html.twig', [
    'pageActive' => $pageActive,
    'user_role' => $user_role,
    'user_login' => $user_login,
]);
