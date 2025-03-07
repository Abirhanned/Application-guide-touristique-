<?php
require_once 'vendor/autoload.php'; // Charger Composer et Twig

$host = 'localhost';
$dbname = 'appli_tourisme';
$username = 'root';
$password = '';

try {
    // Connexion à la base de données
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialiser les variables
    $places = [];
    $city = isset($_GET['city']) ? $_GET['city'] : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';

    // Tables et leurs colonnes correspondantes
    $tables = [
        'hotels' => 'id, nom, adresse, position_gps, description',
        'musees' => 'id, nom, adresse, position_gps, description',
        'jardins' => 'id, nom, adresse, position_gps, description',
        'restaurants' => 'id, nom, adresse, position_gps, description'
    ];

    if (!empty($city)) {
        if (!empty($type) && array_key_exists($type, $tables)) {
            $query = $db->prepare("SELECT $tables[$type] FROM $type WHERE ville LIKE :city");
            $query->execute([':city' => "%$city%"]);
            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $place) {
                $gps = explode(',', $place['position_gps']);
                $places[] = array_merge($place, [
                    'lat' => isset($gps[0]) ? (float) $gps[0] : null,
                    'lon' => isset($gps[1]) ? (float) $gps[1] : null,
                ]);
            }
        } else {
            foreach ($tables as $table => $columns) {
                $query = $db->prepare("SELECT $columns FROM $table WHERE ville LIKE :city");
                $query->execute([':city' => "%$city%"]);
                foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $place) {
                    $gps = explode(',', $place['position_gps']);
                    $places[] = array_merge($place, [
                        'lat' => isset($gps[0]) ? (float) $gps[0] : null,
                        'lon' => isset($gps[1]) ? (float) $gps[1] : null,
                        'type' => $table
                    ]);
                }
            }
        }
    }

    $typeDetail = $_GET['type'] ?? null;
    $idDetail = $_GET['id'] ?? null;

    if ($typeDetail && $idDetail) {
        $queryDetail = $db->prepare("SELECT * FROM $typeDetail WHERE id = :id");
        $queryDetail->execute([':id' => $idDetail]);
        $placeDetail = $queryDetail->fetch(PDO::FETCH_ASSOC);

        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader);

        if ($placeDetail) {
            echo $twig->render('details.html.twig', [
                'place' => $placeDetail,
                'type' => $typeDetail,
            ]);
        } else {
            echo 'Lieu introuvable.';
        }
    } else {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $twig = new \Twig\Environment($loader);
        $pageActive = 'recherche';

        echo $twig->render('recherche.html.twig', [
            'places' => $places,
            'city' => $city,
            'type' => $type,
            'pageActive' => $pageActive,
        ]);
    }

} catch (PDOException $e) {
    echo 'Erreur de connexion à la base de données : ' . $e->getMessage();
} catch (Exception $e) {
    echo 'Erreur générale : ' . $e->getMessage();
}
?>
