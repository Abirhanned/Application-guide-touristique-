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

// Données pour Lyon (2 jours)
$programme = [
    'titre' => '2 jours à Lyon : Presqu’île, Vieux Lyon, Fourvière, Tête d’Or, Confluence',
    'description' => 'Découvrez les lieux incontournables de Lyon en deux jours.',
    'jours' => [
        [
            'titre' => 'Jour 1 : Presqu’île, Vieux Lyon et Fourvière',
            'points' => [
                'Place Bellecour : Le cœur de la Presqu’île avec une vue sur Fourvière.',
                'Vieux Lyon : Explorez les traboules et les cours intérieures.',
                'Colline de Fourvière : Visitez le Théâtre Gallo-Romain et la Basilique de Fourvière.',
                'Cathédrale Saint-Jean : Un chef-d’œuvre gothique dans le Vieux Lyon.',
                'Place du Change : La plus belle place du quartier.',
                'Place des Terreaux : Admirez la fontaine Bartholdi et le Musée des Beaux-Arts.',
            ],
        ],
        [
            'titre' => 'Jour 2 : Tête d’Or, Quai du Rhône, Guillotière et Confluence',
            'points' => [
                'Parc de la Tête d’Or : Découvrez le jardin botanique, le zoo et le lac.',
                'Quai du Rhône : Promenade le long du fleuve.',
                'Quartier de la Guillotière : Un quartier multiculturel et étudiant.',
                'Musée des Confluences : Un musée d’histoire naturelle et d’ethnologie.',
                'Quartier de la Confluence : Un quartier moderne et culturel.',
            ],
        ],
    ],
    'conseils' => [
        'Utilisez le funiculaire pour monter à Fourvière sans effort.',
        'Goûtez aux spécialités lyonnaises dans un bouchon traditionnel.',
        'Prenez le temps de flâner dans les traboules du Vieux Lyon.',
    ],
];
$pageActive = 'programme';

// Rendre le template Twig avec les données
echo $twig->render('lyon.html.twig', [
    'pageActive' => $pageActive,
    'programme' => $programme
]);
?>