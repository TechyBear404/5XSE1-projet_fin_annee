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
    'title' => "Page de connection",
    'description' => "Formulaire de connection a un compte utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'login'
  ];
}

function index(?array $args = []): void
{
  // Afficher la page de connection.
  showView(getPageInfos(), 'login', $args);
}

function loginUser(): void
{
  // $args = [];
  $formRules = getRules();
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;
  // echo '<pre>' . print_r($args, true) . '</pre>';
  // Appeler la vue.
  if (empty($errors)) {
    $pseudo = $valeursEchappees["pseudo"];
    $password = $valeursEchappees["password"];

    $user = connectUser($pseudo, $password);
    if ($user) {

      header('Location: ' . BASE_URL . '/profile');
    } else {
      $args["errors"]["db"] = "Une erreur s'est produite lors de la connection de votre compte.";
      index($args);
    }
  } else {
    index($args);
  }
}
