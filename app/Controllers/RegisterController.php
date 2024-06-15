<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'Mail.php';

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
  // check if the tokenCSRF is valid
  if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
    $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
    index($args);
    exit();
  } else {
    // remove "tokenCSRF" from the array $_POST if it's valid
    unset($_POST["tokenCSRF"]);
  }

  $formRules = getRegisterRules();
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // Appeler la vue.
  if (empty($errors)) {
    $pseudo = $valeursEchappees["pseudo"];
    $email = $valeursEchappees["email"];
    $password = $valeursEchappees["password"];
    $validationToken = bin2hex(random_bytes(8));

    $newUser = createNewUser($pseudo, $email, $password, $validationToken);
    if ($newUser) {
      // echo '<pre>' . print_r($newUser, true) . '</pre>';
      sendVerificationMail($email, $validationToken);
      $args = [];
      $args["success"]["registration"] = "Votre compte a été créé avec succès. Veuillez vérifier votre adresse email pour activer votre compte.";
    } else {
      $args["errors"]["registration"] = "Une erreur s'est produite lors de la création de votre compte.";
    }
    // echo '<pre>' . print_r($newUser, true) . '</pre>';
    index($args);
  } else {
    index($args);
  }
}
