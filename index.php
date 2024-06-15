<?php
// Importer le routeur d'URL.
define('DS', DIRECTORY_SEPARATOR);
require_once __DIR__ . DS . 'core' . DS . 'Routeur.php';
require_once __DIR__ . DS . 'core' . DS . 'Session.php';


// Permet de distinguer le mode développement du mode production.
// Ceci me permet d'utiliser des conditions pour réaliser certaines actions seulement si je suis dans un mode spécifique.
// Par exemple, dans le fichier /core/gestion_bdd.php, les erreurs ne s'afficheront dans le navigateur que si la constante DEV_MODE a été définie et que sa valeur vaut "true".
define('DEV_MODE', false);

// charger les variables d'environnement
if (DEV_MODE === true) {
    $env = file_get_contents(__DIR__ . "/.env.local");
} elseif (DEV_MODE === false) {
    $env = file_get_contents(__DIR__ . "/.env");
}
$lines = explode("\n", $env);

foreach ($lines as $line) {
    preg_match("/([^#]+)\=(.*)/", $line, $matches);
    if (isset($matches[2])) {
        putenv(trim($line));
    }
}

// Chemin de base de l'application (Utile si l'application est hebergée dans un sous-dossier. Dans ce cas, n'oubliez pas d'adapter le fichier .htaccess).
// Par exemple si votre url racine est le suviant : localhost/monprojet/,
// Alors vous devrez configurer BASE_URL à '/monprojet' et dans le fichier .htacces : RewriteCond %{REQUEST_URI} !^/monprojet/public/
define('BASE_URL', '');

// Définir la langue.
// define('LANGUE', 'fr');


// Routes :
// $patterns = ['id' => '\d+'];
$patterns = [
    'email' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}',
    'token' => '[a-zA-Z0-9]+'
];

$routes = [
    getRoute('GET', '/', 'AccueilController', 'index'),
    getRoute('POST', '/', 'AccueilController', 'newPost'),
    getRoute('GET', '/login', 'LoginController', 'index'),
    getRoute('POST', '/login', 'LoginController', 'loginUser'),
    getRoute('GET', '/verify/{email}/{token}', 'LoginController', 'verifyEmail'),
    getRoute('GET', '/register', 'RegisterController', 'index'),
    getRoute('POST', '/register', 'RegisterController', 'createUser'),
    getRoute('GET', '/contact', 'ContactController', 'index'),
    getRoute('POST', '/contact', 'ContactController', 'sendContactRequest'),
    getRoute('GET', '/profile', 'ProfileController', 'index'),
    getRoute('GET', '/logout', 'ProfileController', 'logout'),
    getRoute('POST', '/profile', 'ProfileController', 'editProfile'),
    getRoute('POST', '/post/delete', 'AccueilController', 'deletePost'),
    getRoute('POST', '/post/edit', 'AccueilController', 'editPost'),

];

startRouter($routes, $patterns);
