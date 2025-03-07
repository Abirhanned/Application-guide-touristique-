<?php
session_start();
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$host = 'localhost';
$dbname = 'appli_tourisme';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupérer les restaurants
$queryRestaurants = $db->query("SELECT id, nom, ville, cuisine FROM restaurants");
$restaurants = $queryRestaurants->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les types de cuisine
$queryCuisines = $db->query("SELECT DISTINCT cuisine FROM restaurants");
$cuisines = $queryCuisines->fetchAll(PDO::FETCH_COLUMN);

// Charger Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);
$pageActive = 'recherche'; 

// Afficher la page avec les données
echo $twig->render('rechercheRestaurant.html.twig', [
    'restaurants' => $restaurants,
    'cuisines' => $cuisines,
    'pageActive' => $pageActive,
]);
