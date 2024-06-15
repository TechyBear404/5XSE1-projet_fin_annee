<?php
// Including required files
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';

// Initialize an empty array
$args = [];

// Function to get page information
function getPageInfos(): array
{
  return [
    'vue' => 'profile',
    'title' => "Mon Profil",
    'description' => "Page du profil utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'profile'
  ];
}

// Index function
function index(?array $args = []): void
{
  // Check if user is connected
  if (!isConnected()) {
    header('Location: ' . BASE_URL . '/login');
    exit();
  }

  // Get user by ID
  $user = getUserByID($_SESSION['user']['id']);
  $args['user'] = $user;

  // Show the view
  showView(getPageInfos(), 'index', $args);
}

// Logout function
function logout(): void
{
  // Destroy the session
  session_destroy();

  // Redirect to the home page
  header('Location: ' . BASE_URL . '/');
  exit();
}

// Edit profile function
function editProfile(?array $args = []): void
{
  // Check if user is connected
  if (!isConnected()) {
    header('Location: ' . BASE_URL . '/login');
    exit();
  }

  // Check for CSRF token
  if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
    $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
    index($args);
    exit();
  } else {
    unset($_POST["tokenCSRF"]);
  }

  // Get edit profile rules
  $formEditProfileRules = getEditProfileRules();

  // Initialize form rules
  $formRules = ["rules" => [], "inputNames" => $formEditProfileRules["inputNames"], "errors" => $formEditProfileRules["errors"]];

  // Set rules for each field
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

  // Verify the fields
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // If no errors, update user
  if (empty($errors) && !empty($valeursEchappees)) {
    $user = [
      "id" => $_SESSION['user']['id'],
      "pseudo" => $valeursEchappees["pseudo"] ?? null,
      "email" => $valeursEchappees["email"] ?? null,
      "password" => $valeursEchappees["passwordNew"] ?? null
    ];

    $updatedUser = updateUser($user);
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
