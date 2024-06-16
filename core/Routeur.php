<?php
// Fonction pour obtenir une route :
function getRoute(string $method, string $path, string $controller, string $action): array
{
    return [
        'method' => $method,
        'path' => $path,
        'controller' => $controller,
        'action' => $action,
    ];
}

function preparePath(string $path, array $patterns): string
{
    // Effacer les slashs présent au début et en fin d'URL.
    $path = trim($path, '/');

    // Parcourir les patterns :
    foreach ($patterns as $marqueur => $pattern) {
        // Remplacer {marqueur} par l'expression régulière correspondant
        // ex.: "/admin-gestion-utilisateur/{id}" sera remplacé par "/admin-gestion-utilisateur/(\d+)".
        $path = str_replace('{' . $marqueur . '}', '(' . $pattern . ')', $path);
    }
    return $path;
}

// Fonction pour tester les routes :
function startRouter(array $routes, ?array $patterns = []): void
{
    // Récupérer les différents segments de l'URL dans "$_GET['url']".
    // Ceci est rendu possible grace à cette ligne dans le fichier ".htaccess" : RewriteRule ^(.*)$ public/index.php?url=$1 [QSA,L]
    // Éviter les injection de code à l'aide de la fonction filter_input :
    // "INPUT_GET" indique que la fonction doit récupérer la variable depuis la superglobale "$_GET".
    // "url" est le nom qu'on lui a attribué dans le fichier ".htaccess"
    // "FILTER_SANITIZE_URL" est le filtre utilisé pour nettoyer la variable en supprimant tous les caractères illégaux d'une URL.
    $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL) ?? "";

    // Effacer les slashs présent au début et en fin d'url.
    $url = trim($url, '/');

    // Récupérer la méthode de la requête serveur ("GET" ou "POST").
    $method = $_SERVER['REQUEST_METHOD'];

    // Si la méthode est "POST", on vérifie si une méthode particulière a été ajoutée dans les champs cachés du formulaire ("PUT" ou "DELETE").
    $method = ($method === 'POST') && isset($_POST['_method']) ? strtoupper($_POST['_method']) : $method;

    // Traiter chaque route :
    foreach ($routes as $route) {
        // Préparer le path pour vérifier s'il correspond à l'URL et ce même si celui-ci est composé de marqueur (ex.: {id}).
        $path = preparePath($route['path'], $patterns);

        // Vérifier si la route courante correspond au type de requête ainsi qu'à l'URL et récupérer les potentiels paramètres d'URL avec "$matches".
        if ($route['method'] === $method && preg_match("#^$path$#", $url, $matches)) {
            // Préparer les paramètres d'URL pour pouvoir les transmettre proprement au contrôleur.
            array_shift($matches);

            lauchController($route['controller'], $route['action'], $matches);
            return;
        }
    }

    // Charger le contrôleur pour la page d'erreur 404.
    lauchController('Erreur404Controller', 'index');
}

function lauchController(string $controller, string $action, ?array $urlParams = []): void
{
    // Charger le contrôleur.
    require_once dirname(__DIR__) . DS . 'app' . DS . 'Controllers' . DS . $controller . '.php';

    // Appeler la fonction adéquate du contrôleur.
    $action(...$urlParams);
}
