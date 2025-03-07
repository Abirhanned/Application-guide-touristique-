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
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupérer les musées
try {
    $queryMusees = $db->query("SELECT id, nom, themes, ville, telephone, site_web, region FROM musees");
    $musees = $queryMusees->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier et formater les URLs des sites web
    foreach ($musees as &$musee) {
        if (!empty($musee['site_web']) && !preg_match("~^(?:f|ht)tps?://~i", $musee['site_web'])) {
            $musee['site_web'] = 'http://' . $musee['site_web']; // Ajouter "http://" si manquant
        }
    }
} catch (PDOException $e) {
    die('Erreur lors de la récupération des musées : ' . $e->getMessage());
}

// Récupérer les thèmes uniques des musées
try {
    $queryThemes = $db->query("SELECT DISTINCT themes FROM musees");
    $themes = $queryThemes->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    die('Erreur lors de la récupération des thèmes : ' . $e->getMessage());
}

// Charger Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);
$pageActive = 'recherche'; 

// Afficher la page avec les données
echo $twig->render('rechercheMusee.html.twig', [
    'musees' => $musees, 
    'themes' => $themes,
    'pageActive' => $pageActive,
]);
?>