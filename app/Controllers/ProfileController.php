<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
// require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';

$args = [];

// Fonction pour récupérer les informations de la page.
function getPageInfos(): array
{
  return [
    'vue' => 'profile',
    'title' => "Mon Profil",
    'description' => "Page du profil utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'profile'
  ];
}

function index(?array $args = []): void
{
  // Vérifier si l'utilisateur est connecté.
  if (!isConnected()) {
    header('Location: ' . BASE_URL . '/login');
    exit();
  }
  $user = getUser($_SESSION['user']['id']);
  $args['user'] = $user;
  // Afficher le profil de l'utilisateur.
  showView(getPageInfos(), 'index', $args);
}

function logout(): void
{
  // Détruire la session.
  session_destroy();
  // Rediriger vers la page d'acceuil.
  header('Location: ' . BASE_URL . '/');
  exit();
}
