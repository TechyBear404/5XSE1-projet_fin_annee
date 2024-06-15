<?php

// Include required files
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'userModel.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'Mail.php';

// Initialize an empty array to store arguments
$args = [];

/**
 * Returns an array with page information
 *
 * @return array
 */
function getPageInfos(): array
{
  return [
    'vue' => 'auth',
    'title' => "Page d'Inscription",
    'description' => "Formulaire d'inscription pour créer un compte utilisateur.",
    'baseUrlPage' => BASE_URL . '/' . 'register'
  ];
}

/**
 * Index function to handle registration form submission
 *
 * @param array $args
 */
function index(?array $args = []): void
{
  // Redirect to profile page if user is already connected
  if (isConnected()) {
    header('Location: ' . BASE_URL . '/profile');
    exit();
  }

  // Show registration form with arguments
  showView(getPageInfos(), 'register', $args);
}

/**
 * Creates a new user and sends verification email
 */
function createUser(): void
{
  // Check if CSRF token is valid
  if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
    $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
    index($args);
    exit();
  } else {
    // Remove CSRF token from POST array
    unset($_POST["tokenCSRF"]);
  }

  // Get registration form rules
  $formRules = getRegisterRules();

  // Verify form fields and validate input
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // If no errors, create new user and send verification email
  if (empty($errors)) {
    $pseudo = $valeursEchappees["pseudo"];
    $email = $valeursEchappees["email"];
    $password = $valeursEchappees["password"];
    $validationToken = bin2hex(random_bytes(8));

    $newUser = createNewUser($pseudo, $email, $password, $validationToken);
    if ($newUser) {
      sendVerificationMail($email, $validationToken);
      $args = [];
      $args["success"]["registration"] = "Votre compte a été créé avec succès. Veuillez vérifier votre adresse email pour activer votre compte.";
    } else {
      $args["errors"]["registration"] = "Une erreur s'est produite lors de la création de votre compte.";
    }
    index($args);
  } else {
    index($args);
  }
}
