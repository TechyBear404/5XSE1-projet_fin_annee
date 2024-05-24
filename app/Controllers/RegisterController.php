<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'FormManager.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Models' . DIRECTORY_SEPARATOR . 'userModel.php';

$args = [];

// Communiquer les informations de la page nécessaire au bon fonctionnement de la vue :
function getPageInfos(): array
{
  return [
    'vue' => 'auth',
    'title' => "Page d'Inscription",
    'description' => "Formulaire d'inscription pour créer un compte utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'register'
  ];
}

// index : Afficher la liste des utilisateurs (il s'agit de la partie chargée par défaut) :
function index(?array $args = []): void
{
  // Afficher la vue "vue_accueil.php".
  showView(getPageInfos(), 'register', $args);
}

// function creer(?array $args = []): void
// {
//   // Appeler la vue.
//   showView(getPageInfos(), 'creer', $args);
// }

function createUser(): void
{
  // $args = [];
  $formRules = getRules();
  [$errors, $valeursEchappees] = verifChamps($formRules["errors"], $formRules["rules"], $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // Appeler la vue.
  index($args);
}