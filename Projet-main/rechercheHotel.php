<?php
session_start();
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Paramètres de connexion à la base de données
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

// Récupérer les hôtels
$queryHotels = $db->query("SELECT id, nom, type, nb_etoiles, ville, telephone, site_web, region FROM hotels");
$hotels = $queryHotels->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les types d'hôtels uniques
$queryTypes = $db->query("SELECT DISTINCT type FROM hotels");
$types = $queryTypes->fetchAll(PDO::FETCH_COLUMN);

// Récupérer les nombres d'étoiles uniques
$queryEtoiles = $db->query("SELECT DISTINCT nb_etoiles FROM hotels ORDER BY nb_etoiles ASC");
$etoiles = $queryEtoiles->fetchAll(PDO::FETCH_COLUMN);

// Charger Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);
$pageActive = 'recherche'; 

// Afficher la page avec les données
echo $twig->render('rechercheHotel.html.twig', [
    'hotels' => $hotels,
    'types' => $types,
    'etoiles' => $etoiles,
    'pageActive' => $pageActive,
]);
?>
