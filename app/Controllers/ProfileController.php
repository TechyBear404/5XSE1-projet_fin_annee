<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
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
  $user = getUserByID($_SESSION['user']['id']);
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


function editProfile(?array $args = []): void
{
  // Vérifier si l'utilisateur est connecté.
  if (!isConnected()) {
    header('Location: ' . BASE_URL . '/login');
    exit();
  }
  // check if the tokenCSRF is valid
  if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
    $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
    index($args);
    exit();
  } else {
    // remove "tokenCSRF" from the array $_POST if it's valid
    unset($_POST["tokenCSRF"]);
  }
  $formEditProfileRules = getEditProfileRules();
  //select rules by edited input in $_POST
  $formRules = ["rules" => [], "inputNames" => $formEditProfileRules["inputNames"], "errors" => $formEditProfileRules["errors"]];
  foreach ($formEditProfileRules["rules"] as $key => $value) {
    if (isset($_POST["pseudo"]) && !empty($_POST["pseudo"]) && $key === "pseudo") {
      $formRules["rules"][$key] = $value;
    } elseif (isset($_POST["email"]) && !empty($_POST["email"]) && $key === "email") {
      $formRules["rules"][$key] = $value;
    } elseif ((isset($_POST["passwordNew"]) && !empty($_POST["passwordNew"]) && $key === "passwordNew") || (isset($_POST["passwordCurrent"]) && !empty($_POST["passwordCurrent"]) && $key === "passwordCurrent") || (isset($_POST["passwordConfirm"]) && !empty($_POST["passwordConfirm"]) && $key === "passwordConfirm")) {
      $formRules["rules"]["passwordCurrent"] = $formEditProfileRules["rules"]["passwordCurrent"];
      $formRules["rules"]["passwordNew"] = $formEditProfileRules["rules"]["passwordNew"];
      $formRules["rules"]["passwordConfirm"] = $formEditProfileRules["rules"]["passwordConfirm"];
      break;
    }
  }
  // Verify the fields.
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // Appeler la vue.
  if (empty($errors) && !empty($valeursEchappees)) {
    $id = $_SESSION['user']['id'];
    $pseudo = $valeursEchappees["pseudo"] ?? null;
    $email = $valeursEchappees["email"] ?? null;
    $password = $valeursEchappees["passwordNew"] ?? null;

    $updatedUser = updateUser($id, $pseudo, $email, $password);
    if ($updatedUser) {
      $args = [];
      $args["success"] = "Votre compte a été edité avec succès.";
    } else {
      $args["errors"]["db"] = "Une erreur s'est produite lors de la modification de votre compte.";
    }
    index($args);
  } else {
    index($args);
  }
}
