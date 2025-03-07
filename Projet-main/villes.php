<?php
require_once 'Villes.php';

try {
    // Connexion à la base de données
    $host = 'localhost';
    $dbname = 'cartes';
    $username = 'root';
    $password = '';

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les données des villes
    $stmt = $pdo->query("SELECT nom, latitude, longitude FROM villes");
    $villes = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $villes[] = new Ville($row['nom'], $row['latitude'], $row['longitude']);
    }

    // Convertir les objets en tableau pour le JSON
    $result = array_map(function($ville) {
        return $ville->toArray();
    }, $villes);

    // Retourner les données au format JSON
    header('Content-Type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
