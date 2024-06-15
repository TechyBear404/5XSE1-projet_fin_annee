<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';
// require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'Session.php';

$args = [];

// Communiquer les informations de la page nécessaire au bon fonctionnement de la vue :
function getPageInfos(): array
{
  return [
    'vue' => 'auth',
    'title' => "Page de connection",
    'description' => "Formulaire de connection a un compte utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'login'
  ];
}

function index(?array $args = []): void
{
  if (isConnected()) {
    header('Location: ' . BASE_URL . '/profile');
    exit();
  }
  // Afficher la page de connection.
  showView(getPageInfos(), 'login', $args);
}
