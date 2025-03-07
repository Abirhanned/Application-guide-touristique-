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

// Données pour Lille (2 jours)
$programme = [
    'titre' => '2 jours à Lille : Vieux-Lille, Citadelle, Musée d’Histoire Naturelle',
    'description' => 'Découvrez les lieux incontournables de Lille en deux jours.',
    'jours' => [
        [
            'titre' => 'Jour 1 : Le Vieux-Lille & le quartier Saint-Sauveur',
            'points' => [
                'Place Rihour : Découvrez le Palais Rihour et l’office du tourisme.',
                'Grand’Place : Admirez la Vieille Bourse et le Beffroi de la Chambre de Commerce.',
                'Rue de la Grande Chaussée : Flânez dans l’une des plus vieilles rues de Lille.',
                'Place aux Oignons : Profitez des restaurants et terrasses fleuries.',
            ],
        ],
        [
            'titre' => 'Jour 2 : La Citadelle & Le Musée d’Histoire Naturelle',
            'points' => [
                'Quai du Wault : Baladez-vous au fil de l’eau.',
                'Parc de la Citadelle : Détendez-vous dans ce vaste espace vert.',
                'Méert : Dégustez les fameuses gaufres fourrées à la vanille.',
            ],
        ],
    ],
    'conseils' => [
        'Réservez votre visite du Beffroi de l’Hôtel de Ville à l’avance.',
        'Goûtez aux spécialités locales comme les gaufres Méert et les plats flamands.',
        'Profitez des expositions gratuites à la Gare Saint-Sauveur.',
    ],
];
$pageActive = 'programme';

// Rendre le template Twig avec les données
echo $twig->render('lille.html.twig', [
    'pageActive' => $pageActive,
    'programme' => $programme
]);
?>