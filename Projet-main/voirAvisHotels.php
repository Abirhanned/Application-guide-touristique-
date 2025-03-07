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
$typeHotel = 'Hotel'; // Fixer le type à "Hotel"

// Requête pour récupérer les hôtels
$queryHotels = $db->prepare("
    SELECT avis.nom, 
           ROUND(AVG(avis.note), 1) AS moyenne, 
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

$queryHotels->bindValue(':ville', $ville ?: NULL, PDO::PARAM_STR);
$queryHotels->bindValue(':type', $typeHotel);
$queryHotels->bindValue(':offset', $offset, PDO::PARAM_INT);
$queryHotels->bindValue(':perPage', $perPage, PDO::PARAM_INT);
$queryHotels->execute();

$result = $queryHotels->fetchAll(PDO::FETCH_ASSOC);

// Requête pour compter le nombre total d'hôtels
$totalQuery = $db->prepare("
    SELECT COUNT(DISTINCT avis.nom) 
    FROM avis
    WHERE (:ville IS NULL OR avis.ville = :ville)
      AND avis.type = :type
");

$totalQuery->bindValue(':ville', $ville ?: NULL, PDO::PARAM_STR);
$totalQuery->bindValue(':type', $typeHotel);
$totalQuery->execute();

$totalHotels = $totalQuery->fetchColumn();
$totalPages = ceil($totalHotels / $perPage);

// Requête pour récupérer les villes uniques
$queryVilles = $db->query("
    SELECT DISTINCT ville 
    FROM avis 
    WHERE ville IS NOT NULL 
      AND TRIM(ville) != '' 
      AND type LIKE 'Hotel'
    ORDER BY ville ASC
");
$villes = $queryVilles->fetchAll(PDO::FETCH_ASSOC);

// Charger Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

// Définir les données pour Twig
echo $twig->render('voirAvisDetails.html.twig', [
    'pageActive' => 'avis',
    'pageAvis' => 'hotels',
    'type' => "de l'hôtel",
    'result' => $result,
    'villes' => $villes,
    'villeChoisie' => $ville,
    'totalPages' => $totalPages,
    'currentPage' => $page
]);
