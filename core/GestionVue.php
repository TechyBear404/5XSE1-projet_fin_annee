<?php

function showView(array $pageInfos, string $action, ?array $args = []): void
{
    echo '<pre>' . print_r($args, true) . '</pre>';
    // Enregistrer le chemin vers le dossier des vues pour faciliter la lecture et éviter les répétitions.
    $viewPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR;

    // Enregistrer le chemin vers le dossier "part" des vues, contenant les différentes parties du modèle de page (entête et pied de page) pour les mêmes raisons.
    $viewPathComponents = $viewPath . 'components' . DIRECTORY_SEPARATOR;

    if ($args !== null) {
        extract($args);
    }
    // Importer l'entête.
    require_once $viewPathComponents . 'header.php';
    // Importer le contenu de la page.
    require_once $viewPath . $pageInfos['vue'] . DIRECTORY_SEPARATOR . $action . '.php';
    // Importer le pied de page.
    require_once $viewPathComponents . 'footer.php';
}
