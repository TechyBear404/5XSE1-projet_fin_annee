<?php

// Include required files
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';

// Initialize an empty array for arguments
$args = [];

/**
 * Get page info
 * 
 * Returns an array containing page information
 * 
 * @return array
 */
function getPageInfos(): array
{
  return [
    'vue' => 'auth',
    'title' => "Page de connection",
    'description' => "Formulaire de connection a un compte utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'login'
  ];
}

/**
 * Index function
 * 
 * Handles login functionality
 * 
 * @param array $args Optional arguments
 */
function index(?array $args = []): void
{
  // If user is already connected, redirect to profile page
  if (isConnected()) {
    header('Location: ' . BASE_URL . '/profile');
    exit();
  }

  // Show login view
  showView(getPageInfos(), 'login', $args);
}

/**
 * Login user
 */
function loginUser(): void
{
  // Get login form rules
  $formRules = getLoginRules();

  // Check CSRF token
  if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
    $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
    index($args);
    exit();
  } else {
    // Remove CSRF token from $_POST
    unset($_POST["tokenCSRF"]);
  }

  // Validate form fields
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // If no errors, attempt to login
  if (empty($errors)) {
    $email = $valeursEchappees["email"];
    $password = $valeursEchappees["password"];

    // Connect user
    $user = connectUser($email, $password);
    if (isset($user["success"])) {
      // Redirect to profile page on success
      header('Location: ' . BASE_URL . '/' . 'profile');
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

/**
 * Verify email
 * 
 * @param string $email Email address
 * @param string $token Activation token
 */
function verifyEmail(string $email, string $token): void
{
  // Get user by email
  $user = getUserByEmail($email);
  if ($user) {
    if ($user["useActivationToken"] === $token) {
      // Activate user
      activateUser($user["useID"]);
      $args["success"] = "Votre compte a été vérifié avec succès.";
    } else {
      $args["errors"]["token"] = "Le token de validation est incorrect.";
    }
  } else {
    $args["errors"]["email"] = "L'adresse email est incorrecte.";
  }
  index($args);
}
