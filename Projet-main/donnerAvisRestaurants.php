<?php
session_start();
require 'vendor/autoload.php';  // Assurez-vous que Twig est bien chargé

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Paramètres de connexion à la base de données
$host = 'localhost';
$dbname = 'appli_tourisme';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

$errors = [];
$success = '';

// Récupérer les restaurants depuis la base de données
try {
    $result = $db->query('SELECT CONCAT(nom, " (", code_ville, ")") as nom FROM restaurants WHERE nom IS NOT NULL AND TRIM(nom) != ""')->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errors[] = "Erreur lors de la récupération des restaurants : " . $e->getMessage();
}
$restaurantSelectionne = null;

// Récupérer l'ID de l'hôtel depuis l'URL (et le forcer en entier pour éviter les injections SQL)
$id = $_GET['id'] ?? null;


$selectionne = null; // ✅ Initialisation de la variable pour éviter les erreurs

if ($id) {
    try {
        // Utilisation correcte des guillemets simples et doubles
        $stmt = $db->prepare("SELECT CONCAT(nom, ' (', code_ville, ')') AS nom FROM restaurants WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $selectionne = $stmt->fetchColumn(); // ✅ Récupère le nom sous forme de texte

        if (!$selectionne) {
            $errors[] = "Le restaurant sélectionné n'existe pas.";
            $id = null;
        }
    } catch (PDOException $e) {
        $errors[] = "Erreur lors de la récupération des informations du restaurant : " . $e->getMessage();
    }
}





// Traitement du formulaire lors de la soumission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $note = $_POST['note'];
    $avis = $_POST['avis'];
    $pseudo = $_POST['pseudo'];

    // Validation des données
    if (empty($nom) || empty($date) || empty($note) || empty($avis) || empty($pseudo)) {
        $errors[] = "Tous les champs sont obligatoires.";
    }

    // Si pas d'erreurs, on récupère le code ville du restaurant
    if (empty($errors)) {
        try {
            // Récupérer le code ville du restaurant sélectionné
            $stmt = $db->prepare("SELECT code_ville, id, ville FROM restaurants WHERE CONCAT(nom, ' (', code_ville, ')') = :nom");
            $stmt->execute([':nom' => $nom]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $code_ville = $result['code_ville'];
                $ville = $result['ville'];
                $id = $result['id'];

                // Insertion dans la base de données
                $stmt = $db->prepare("INSERT INTO avis (nom,id, date, note, avis, pseudo, type, code_postal, ville) 
                                      VALUES (:nom,:id, :date, :note, :avis, :pseudo, 'Restaurant', :code_ville, :ville)");

                // Exécution de la requête avec les données envoyées
                $stmt->execute([
                    ':nom' => $nom,
                    ':date' => $date,
                    ':note' => $note,
                    ':avis' => $avis,
                    ':pseudo' => $pseudo,
                    ':code_ville' => $code_ville,
                    ':ville' => $ville,
                    ':id' => $id
                ]);

                $success = "Votre avis a été enregistré avec succès!";
            } else {
                $errors[] = "Le restaurant sélectionné n'existe pas.";
            }
            $result = $db->query('SELECT CONCAT(nom, " (", code_ville, ")") as nom FROM restaurants WHERE nom IS NOT NULL AND TRIM(nom) != ""')->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'enregistrement de l'avis : " . $e->getMessage();
            echo $e->getMessage();  // Affiche l'erreur SQL
        }
    }
}


// Charger le template Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$pageActive = 'avis';
$pageAvis = 'Restaurants'; 
$type = "du restaurant"; 
$type2 = "restaurant"; 

// Affichage du template avec les variables
echo $twig->render('donnerAvisDetails.html.twig', [
    'result' => $result,
    'errors' => $errors,
    'success' => $success,
    'pageActive' => $pageActive,
    'pageAvis' => $pageAvis,
    'type' => $type,
    'type2' => $type2,
    'selectionne' => $selectionne
]);
?>
