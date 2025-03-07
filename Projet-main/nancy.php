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

// Données pour Nancy (2 jours)
$programme = [
    'titre' => '2 jours à Nancy : Place Stanislas, Art Nouveau, Château de Fléville',
    'description' => 'Découvrez les lieux incontournables de Nancy en deux jours.',
    'jours' => [
        [
            'titre' => 'Jour 1 : Place Stanislas, Art Nouveau et Musée des Beaux-Arts',
            'points' => [
                'Place Stanislas : Le cœur historique et culturel de Nancy.',
                'Spectacle de Sons et Lumières : Un spectacle immersif sur l\'histoire de la ville.',
                'Maison des Sœurs Macaron : Découvrez l\'histoire du macaron de Nancy.',
                'Musée de l\'École de Nancy : Plongez dans l\'univers de l\'Art Nouveau.',
                'Musée des Beaux-Arts : Une collection variée allant de la peinture à la verrerie.',
            ],
        ],
        [
            'titre' => 'Jour 2 : Château de Fléville, Street-Art et Parc de la Pépinière',
            'points' => [
                'Château de Fléville : Un château médiéval et Renaissance à 20 minutes de Nancy.',
                'Street-Art à Nancy : Découvrez les œuvres modernes qui animent les murs de la ville.',
                'Parc de la Pépinière : Le poumon vert de Nancy, idéal pour une promenade relaxante.',
            ],
        ],
    ],
    'conseils' => [
        'Profitez du spectacle de Sons et Lumières si vous visitez entre juin et septembre.',
        'Goûtez aux spécialités locales comme le macaron de Nancy et les bonbons à la mirabelle.',
        'Prenez le temps de flâner dans les jardins du Musée de l\'École de Nancy.',
    ],
];
$pageActive = 'programme';

// Rendre le template Twig avec les données
echo $twig->render('nancy.html.twig', [
    'pageActive' => $pageActive,
    'programme' => $programme
]);
?>