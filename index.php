<?php
// Importer le routeur d'URL.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'Routeur.php';

// Permet de distinguer le mode développement du mode production.
// Ceci me permet d'utiliser des conditions pour réaliser certaines actions seulement si je suis dans un mode spécifique.
// Par exemple, dans le fichier /core/gestion_bdd.php, les erreurs ne s'afficheront dans le navigateur que si la constante DEV_MODE a été définie et que sa valeur vaut "true".
define('DEV_MODE', true);

// Chemin de base de l'application (Utile si l'application est hebergée dans un sous-dossier. Dans ce cas, n'oubliez pas d'adapter le fichier .htaccess).
// Par exemple si votre url racine est le suviant : localhost/monprojet/,
// Alors vous devrez configurer BASE_URL à '/monprojet' et dans le fichier .htacces : RewriteCond %{REQUEST_URI} !^/monprojet/public/
define('BASE_URL', '/5xse1/projet_fin_annee');

// Définir la langue.
// define('LANGUE', 'fr');

// Routes :
$patterns = ['id' => '\d+'];
$routes = [
    getRoute('GET', '/', 'AccueilController', 'index'),
    // create routes for authetication page login register
    getRoute('GET', '/login', 'LoginController', 'index'),
    getRoute('POST', '/login', 'LoginController', 'connectUser'),
    getRoute('GET', '/register', 'RegisterController', 'index'),
    getRoute('POST', '/register', 'RegisterController', 'createUser'),
    getRoute('GET', '/contact', 'ContactController', 'index'),
    getRoute('POST', '/contact', 'ContactController', 'sendContactRequest'),
    // getRoute('GET', '/user', 'AuthController', 'index'),
    // getRoute('GET', '/user/create', 'AuthController', 'create'),
    // getRoute('GET', '/user/', 'AuthController', 'index'),
    // getRoute('GET', '/admin-gestion-utilisateur', 'AdminGestionUtilisateurController', 'index'),
    // getRoute('DELETE', '/admin-gestion-utilisateur', 'AdminGestionUtilisateurController', 'detruire'),
    // getRoute('GET', '/admin-gestion-utilisateur/creer', 'AdminGestionUtilisateurController', 'creer'),
    // getRoute('POST', '/admin-gestion-utilisateur/creer', 'AdminGestionUtilisateurController', 'stocker'),
    // getRoute('GET', '/admin-gestion-utilisateur/{id}', 'AdminGestionUtilisateurController', 'montrer'),
    // getRoute('GET', '/admin-gestion-utilisateur/{id}/editer', 'AdminGestionUtilisateurController', 'editer'),
    // getRoute('PUT', '/admin-gestion-utilisateur/{id}/editer', 'AdminGestionUtilisateurController', 'actualiser')
];

startRouter($routes, $patterns);
