<?php

// Démarrer la session
session_start();

require 'vendor/autoload.php'; // Autoloader pour Twig

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Initialiser Twig
$loader = new FilesystemLoader('templates'); 
$twig = new Environment($loader);

// Données pour l'affichage des villes
$villes = [
    'paris' => 'Paris',
    'lyon' => 'Lyon',
    'lille' => 'Lille',
    'nancy' => 'Nancy',
    'marseille' => 'Marseille',
];
$pageActive = 'programme'; 

// Rendu de la page template avec les villes
echo $twig->render('programme.html.twig', [
    'pageActive' => $pageActive,
    'villes' => $villes
]);

?>
