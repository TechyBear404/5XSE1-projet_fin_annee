<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';

// phpinfo();
// Communiquer les informations de la page nécessaire au bon fonctionnement de la vue :
function getPageInfos(): array
{
    return [
        'vue' => 'accueil',
        'title' => "Page d'Accueil",
        'description' => "Description de la page d'accueil..."
    ];
}

// index : Afficher la liste des utilisateurs (il s'agit de la partie chargée par défaut) :
function index(): void
{
    // Afficher la vue "vue_accueil.php".
    showView(getPageInfos(), 'index');
}
