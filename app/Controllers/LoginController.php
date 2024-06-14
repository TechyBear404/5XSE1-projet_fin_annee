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

function loginUser(): void
{
  $formRules = getLoginRules();

  // check if the tokenCSRF is valid
  if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
    $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
    index($args);
    exit();
  } else {
    // remove "tokenCSRF" from the array $_POST if it's valid
    unset($_POST["tokenCSRF"]);
  }

  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;
  // Call Vue.
  if (empty($errors)) {
    $pseudo = $valeursEchappees["pseudo"];
    $password = $valeursEchappees["password"];

    $user = connectUser($pseudo, $password);

    if (isset($user["success"])) {
      header('Location: ' . BASE_URL . '/profile');
      exit();
    } elseif (isset($user["error"])) {
      $args["errors"] = $user["error"];
      index($args);
      exit();
    }
  } else {
    index($args);
  }
}
