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

// Données pour Marseille (2 jours)
$programme = [
    'titre' => '2 jours à Marseille : Vieux-Port, Mucem, Notre-Dame de la Garde, Cours Julien',
    'description' => 'Découvrez les incontournables de Marseille en deux jours.',
    'jours' => [
        [
            'titre' => 'Jour 1 : Vieux-Port, Mucem, Panier, Major, Notre-Dame de la Garde',
            'points' => [
                'Vieux-Port : Le cœur historique de Marseille et son marché aux poissons.',
                'Mucem : Le musée des civilisations de l\'Europe et de la Méditerranée.',
                'Grotte Cosquer : Une réplique de la grotte préhistorique sous-marine.',
                'Le Panier : Le plus vieux quartier de Marseille, rempli de charme et de street art.',
                'Cathédrale de la Major : Un monument impressionnant à l\'architecture néo-byzantine.',
                'Notre-Dame de la Garde : La "Bonne Mère" des Marseillais, avec une vue panoramique sur la ville.',
            ],
        ],
        [
            'titre' => 'Jour 2 : Noailles, Cours Julien, Malmousque, Vallon des Auffes, Plages du Prado',
            'points' => [
                'Marché de Noailles : Un marché coloré et animé aux saveurs orientales.',
                'Cours Julien : Le quartier des artistes, rempli de street art et de restaurants.',
                'Malmousque et Vallon des Auffes : Deux petits ports pittoresques pour une balade relaxante.',
                'Plages du Prado : Profitez de la mer et des activités nautiques.',
            ],
        ],
    ],
    'conseils' => [
        'Profitez du spectacle de Sons et Lumières si vous visitez entre juin et septembre.',
        'Goûtez aux spécialités locales comme la bouillabaisse ou les navettes.',
        'Prenez le temps de flâner dans les ruelles du Panier pour découvrir son street art.',
    ],
];
$pageActive = 'programme';

// Rendre le template Twig avec les données
echo $twig->render('marseille.html.twig', [
    'pageActive' => $pageActive,
    'programme' => $programme
]);
?>