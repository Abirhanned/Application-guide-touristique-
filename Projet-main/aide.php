<?php
// Démarrer la session (si nécessaire)
session_start();

// Charger l'autoloader de Twig
require 'vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// Initialiser Twig
$loader = new FilesystemLoader('templates'); // Dossier contenant les templates Twig
$twig = new Environment($loader);

// Données pour la page Aide (si nécessaire)
$data = [
    'pageTitle' => 'Aide & Support',
    'pageDescription' => 'Trouvez des réponses à vos questions et découvrez comment utiliser au mieux notre application.',
    'faq' => [
        [
            'question' => 'Comment créer un compte ?',
            'answer' => 'Pour créer un compte, cliquez sur "S\'inscrire" depuis la page d\'accueil et suivez les instructions.',
        ],
        [
            'question' => 'Comment télécharger un programme de visite hors ligne ?',
            'answer' => 'Accédez au programme de visite d\'une ville et cliquez sur l\'icône de téléchargement.',
        ],
        [
            'question' => 'Comment contacter le support technique ?',
            'answer' => 'Vous pouvez nous contacter par email à <a href="mailto:support@votreapplication.com" class="text-blue-600 hover:text-blue-800">support@votreapplication.com</a>.',
        ],
    ],
    'guide' => [
        [
            'title' => 'Rechercher une ville',
            'description' => 'Utilisez la barre de recherche pour trouver une ville et accéder à son programme de visite.',
        ],
        [
            'title' => 'Utiliser la carte interactive',
            'description' => 'Explorez les points d\'intérêt sur la carte et obtenez des informations détaillées.',
        ],
        [
            'title' => 'Ajouter une ville aux favoris',
            'description' => 'Cliquez sur l\'icône en forme de cœur pour ajouter une ville à vos favoris.',
        ],
    ],
    'contact' => [
        'email' => 'support@votreapplication.com',
        'socialMedia' => [
            ['name' => 'Facebook', 'link' => '#'],
            ['name' => 'Twitter', 'link' => '#'],
            ['name' => 'Instagram', 'link' => '#'],
        ],
    ],
    'usefulLinks' => [
        ['text' => 'Politique de confidentialité', 'link' => '#'],
        ['text' => 'Conditions d\'utilisation', 'link' => '#'],
        ['text' => 'Mises à jour de l\'application', 'link' => '#'],
    ],
    'feedback' => [
        ['text' => 'Noter l\'application', 'link' => '#'],
        ['text' => 'Soumettre une idée', 'link' => '#'],
        ['text' => 'Signaler un bug', 'link' => '#'],
    ],
];
$pageActive = 'aide';

// Rendre le template Twig avec les données
echo $twig->render('aide.html.twig', [
        'pageActive' => $pageActive,
    ]);
?>