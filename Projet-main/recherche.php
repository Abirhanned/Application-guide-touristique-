<?php
require_once 'vendor/autoload.php'; // Charger Composer et Twig

$host = 'localhost';
$dbname = 'appli_tourisme';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialiser les variables
    $places = [];
    $name = isset($_GET['name']) ? trim($_GET['name']) : '';
    $city = isset($_GET['city']) ? trim($_GET['city']) : '';
    $type = isset($_GET['type']) ? trim($_GET['type']) : '';

    // Tables et leurs colonnes correspondantes
    $tables = [
        'hotels' => 'nom, position_gps, ville',
        'musees' => 'nom, position_gps, ville',
        'jardins' => 'nom, position_gps, ville',
        'restaurants' => 'nom, position_gps, ville'
    ];

    // Construire la requête SQL dynamiquement
    if (!empty($name) || !empty($city)) {
        $conditions = [];
        $params = [];

        if (!empty($name)) {
            $conditions[] = "nom LIKE :name";
            $params[':name'] = "%$name%";
        }

        if (!empty($city)) {
            $conditions[] = "ville LIKE :city";
            $params[':city'] = "%$city%";
        }

        $whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";

        // Si une catégorie spécifique est sélectionnée
        if (!empty($type) && array_key_exists($type, $tables)) {
            $query = $db->prepare("SELECT id, nom, position_gps FROM $type $whereClause");
            $query->execute($params);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $place) {
                $gps = explode(',', $place['position_gps']);
                if (count($gps) === 2 && is_numeric($gps[0]) && is_numeric($gps[1])) {
                    $places[] = [
                        'id' => $place['id'],
                        'name' => $place['nom'],
                        'lat' => (float) $gps[0],
                        'lon' => (float) $gps[1],
                        'type' => $type
                    ];
                }
            }
        } else {
            // Récupérer les résultats pour toutes les catégories
            foreach ($tables as $table => $columns) {
                $query = $db->prepare("SELECT id, nom, position_gps FROM $table $whereClause");
                $query->execute($params);

                foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $place) {
                    $gps = explode(',', $place['position_gps']);
                    if (count($gps) === 2 && is_numeric($gps[0]) && is_numeric($gps[1])) {
                        $places[] = [
                            'id' => $place['id'],
                            'name' => $place['nom'],
                            'lat' => (float) $gps[0],
                            'lon' => (float) $gps[1],
                            'type' => $table
                        ];
                    }
                }
            }
        }
    }

    // Initialiser Twig
    $loader = new \Twig\Loader\FilesystemLoader('templates');
    $twig = new \Twig\Environment($loader);
    $pageActive = 'recherche'; 

    // Passer les données au modèle Twig
    echo $twig->render('recherche.html.twig', [
        'places' => $places,
        'name' => $name,
        'city' => $city,
        'type' => $type,
        'pageActive' => $pageActive,
    ]);

} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Erreur générale : ' . $e->getMessage();
}
