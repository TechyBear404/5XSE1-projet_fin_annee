<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';

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
  if (isConnected()) {
    header('Location: ' . BASE_URL . '/profile');
    exit();
  }
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
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // Appeler la vue.
  if (empty($errors)) {
    $pseudo = $valeursEchappees["pseudo"];
    $email = $valeursEchappees["email"];
    $password = $valeursEchappees["password"];

    $newUser = createNewUser($pseudo, $email, $password);
    if ($newUser) {
      // echo '<pre>' . print_r($newUser, true) . '</pre>';
      $user = connectUser($pseudo, $password);
      if ($user) {
        header('Location: ' . BASE_URL . '/profile');
        exit();
      }
      $args = [];
      $args["success"] = "Votre compte a été créé avec succès.";
    } else {
      $args["errors"]["db"] = "Une erreur s'est produite lors de la création de votre compte.";
    }
    // echo '<pre>' . print_r($newUser, true) . '</pre>';
    index($args);
  } else {
    index($args);
  }
}
