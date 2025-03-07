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

// Récupérer les données depuis l'URL
$ville = isset($_GET['ville']) ? trim($_GET['ville']) : null;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 21; // Nombre d'hôtels par page
$offset = ($page - 1) * $perPage;
$typeRestaurant = 'Restaurant'; // Fixer le type à "Restaurant" (ou personnaliser selon vos besoins)

// Requête pour récupérer les hôtels
$queryRestaurants = $db->prepare("
    SELECT avis.nom, 
           ROUND(AVG(avis.note),1) AS moyenne, 
           avis.type,
           id,
           GROUP_CONCAT('De : ', avis.pseudo, ' (', avis.note, '/5) ', avis.avis SEPARATOR 'separator') AS avis
    FROM avis
    WHERE (:ville IS NULL OR avis.ville = :ville)
      AND avis.type = :type
    GROUP BY avis.nom
    ORDER BY moyenne DESC
    LIMIT :offset, :perPage
");

$queryRestaurants->bindValue(':ville', $ville);
$queryRestaurants->bindValue(':type', $typeRestaurant);
$queryRestaurants->bindValue(':offset', $offset, PDO::PARAM_INT);
$queryRestaurants->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$queryRestaurants->execute();

$result = $queryRestaurants->fetchAll(PDO::FETCH_ASSOC);

// Requête pour compter le nombre total d'hôtels
$totalQuery = $db->prepare("
    SELECT COUNT(DISTINCT avis.nom) 
    FROM avis
    WHERE (:ville IS NULL OR avis.ville = :ville)
      AND avis.type = :type
");

$totalQuery->bindValue(':ville', $ville);
$totalQuery->bindValue(':type', $typeRestaurant);
$totalQuery->execute();

$totalRestaurants = $totalQuery->fetchColumn();
$totalPages = ceil($totalRestaurants / $perPage);

// Requête pour récupérer les villes uniques
$queryVilles = $db->query("
    SELECT DISTINCT ville 
    FROM avis 
    WHERE ville IS NOT NULL 
      AND TRIM(ville) != '' 
      AND type LIKE 'Restaurant'
    ORDER BY ville ASC
");
$villes = $queryVilles->fetchAll(PDO::FETCH_ASSOC);

// Charger Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// Définir les données pour Twig
echo $twig->render('voirAvisDetails.html.twig', [
    'pageActive' => 'avis',
    'pageAvis' => 'restaurants',
    'type' => 'du restaurant',
    'result' => $result,
    'villes' => $villes,
    'villeChoisie' => $ville,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);
