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

// Données pour Paris
$programme = [
    'titre' => '2 jours à Paris : Musées et Monuments',
    'description' => 'Découvrez les monuments et musées emblématiques de Paris en une journée.',
    'jours' => [
        [
            'titre' => 'Jour 1 : Musées et monuments parisiens',
            'points' => [
                'Musée du Louvre : Admirez la Joconde, la Vénus de Milo et les Noces de Cana.',
                'Tour Eiffel : Profitez d\'une vue panoramique sur Paris.',
                'Hôtel des Invalides : Découvrez le Musée de l\'Armée et le tombeau de Napoléon.',
                'Arc de Triomphe : Admirez la perspective des Champs-Élysées.',
            ],
        ],
        [
            'titre' => 'Jour 2 : Jardins et quartiers de la capitale',
            'points' => [
                'Parc des Buttes Chaumont : Flânez dans ce jardin paysager.',
                'Montmartre : Explorez le quartier des artistes et la Basilique du Sacré-Cœur.',
                'Quartier Latin : Découvrez son ambiance estudiantine et ses monuments historiques.',
            ],
        ],
    ],
    'conseils' => [
        'Réservez vos billets coupe-file pour le Louvre et la Tour Eiffel.',
        'Utilisez le métro pour vous déplacer facilement dans Paris.',
        'Goûtez aux spécialités parisiennes comme les croissants et les macarons.',
    ],
];
$pageActive = 'programme'; 
// Rendre le template Twig avec les données
echo $twig->render('paris.html.twig', [
    'pageActive' => $pageActive,
    'programme' => $programme
    
]);
?>


