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

$jardinSelectionne = null;

// Récupérer l'ID de l'hôtel depuis l'URL (et le forcer en entier pour éviter les injections SQL)
$id = $_GET['id'] ?? null;


$selectionne = null; // ✅ Initialisation de la variable pour éviter les erreurs

if ($id) {
    try {
        $stmt = $db->prepare("SELECT nom FROM jardins WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $selectionne = $stmt->fetchColumn(); // ✅ Récupère le nom sous forme de texte

        if (!$selectionne) {
            $errors[] = "L'hôtel sélectionné n'existe pas.";
            $id = null;
        }
    } catch (PDOException $e) {
        $errors[] = "Erreur lors de la récupération des informations de l'hôtel : " . $e->getMessage();
    }
}

if ($id) {
    // Vérifier si l'hôtel existe et récupérer ses informations
    try {
        $stmt = $db->prepare("SELECT  nom FROM jardins WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $selectionne = $stmt->fetchColumn();


       

        if (!$selectionne) {
            $errors[] = "L'hôtel sélectionné n'existe pas.";
            $id = null;  // Réinitialiser $id si l'hôtel n'existe pas
        }
    } catch (PDOException $e) {
        $errors[] = "Erreur lors de la récupération des informations de l'hôtel : " . $e->getMessage();
    }
}


// Récupérer les jardins depuis la base de données
try {
    $result = $db->query('SELECT nom FROM jardins WHERE nom IS NOT NULL AND TRIM(nom) != ""')->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errors[] = "Erreur lors de la récupération des jardins : " . $e->getMessage();
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

    if (empty($errors)) {
        try {
            // Récupérer le code postal du jardin sélectionné
            $stmt = $db->prepare("SELECT code_postal, id, ville FROM jardins WHERE nom = :nom");
            $stmt->execute([':nom' => $nom]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Si le jardin existe, on récupère le code postal
                $code_postal = $result['code_postal'];
                $id = $result['id'];
                $ville = $result['ville'];

                // Insertion dans la base de données
                $stmt = $db->prepare("INSERT INTO avis (nom, id, date, note, avis, pseudo, type, code_postal, ville) 
                                      VALUES (:nom, :id, :date, :note, :avis, :pseudo, 'Jardin', :code_postal, :ville)");

                // Exécution de la requête avec les données envoyées
                $stmt->execute([
                    ':nom' => $nom,
                    ':id' => $id,
                    ':date' => $date,
                    ':note' => $note,
                    ':avis' => $avis,
                    ':pseudo' => $pseudo,
                    ':code_postal' => $code_postal,
                    ':ville' => $ville
                ]);

                $success = "Votre avis a été enregistré avec succès!";
            } else {
                // Si le jardin n'existe pas
                $errors[] = "Le jardin sélectionné n'existe pas dans la base de données.";
            }
            $result = $db->query("SELECT  nom FROM jardins WHERE nom IS NOT NULL AND TRIM(nom) != ''")
            ->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de l'enregistrement de l'avis : " . $e->getMessage();
        }
    }
}

// Charger le template Twig
$loader = new FilesystemLoader('templates');
$twig = new Environment($loader);

$pageActive = 'avis';
$pageAvis = 'Jardins'; 
$type = "du jardin"; 
$type2 = "jardin";

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
