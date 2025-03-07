<?php
session_start();

require 'vendor/autoload.php'; // Assurez-vous que Twig est bien chargé

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Paramètres de connexion à la base de données
$host = 'localhost';  // Hôte de la base de données
$dbname = 'appli_tourisme';  // Nom de la base de données
$username = 'root';  // Nom d'utilisateur de la base de données (par défaut 'root' pour XAMPP)
$password = '';  // Le mot de passe de l'utilisateur (par défaut vide pour XAMPP)

try {
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Gérer les erreurs
} catch (PDOException $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}

// Récupérer les paramètres de recherche depuis la requête GET
$nom = isset($_GET['nom']) ? $_GET['nom'] : '';
$ville = isset($_GET['ville']) ? $_GET['ville'] : '';

// Construire la requête SQL en fonction des filtres
$query = "SELECT nom, ville, id, adresse, site_web FROM jardins"; // On garde 'nom' et 'ville' dans la sélection

// Ajouter des conditions de filtre selon les critères
if ($nom) {
    $query .= " WHERE LOWER(nom) LIKE :nom"; // Si 'nom' est fourni, ajoutez un filtre
}

if ($ville) {
    // Si 'ville' est fourni, on l'ajoute comme condition supplémentaire
    $query .= ($nom ? " AND " : " WHERE ") . "LOWER(ville) LIKE :ville";
}

// Préparer et exécuter la requête SQL
$stmt = $db->prepare($query);

if ($nom) {
    $stmt->bindValue(':nom', '%' . strtolower($nom) . '%');
}

if ($ville) {
    $stmt->bindValue(':ville', '%' . strtolower($ville) . '%');
}

$stmt->execute();
$jardins = $stmt->fetchAll(PDO::FETCH_ASSOC);  // Récupérer tous les résultats sous forme de tableau associatif

// Initialiser Twig
$loader = new FilesystemLoader('templates'); // Assurez-vous que 'templates' contient 'rechercheJardin.html.twig'
$twig = new Environment($loader);
$pageActive = 'recherche'; 

// Passer les données à Twig
echo $twig->render('rechercheJardin.html.twig', [
    'jardins' => $jardins, // Passe les données des jardins à Twig
    'pageActive' => $pageActive,
]);
?>