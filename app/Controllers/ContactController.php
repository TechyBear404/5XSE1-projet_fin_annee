<?php
// Include necessary files
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'contactModel.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'Mail.php';

// Initialize an empty array for arguments
$args = [];

/**
 * Function to get page info
 * Returns an array with page information
 */
function getPageInfos(): array
{
  return [
    'vue' => 'contact',
    'title' => "Page de contact",
    'description' => "Formulaire de contact.",
    'baseUrlPage' => BASE_URL . '/' . 'contact'
  ];
}

/**
 * Index function to show the contact page
 * @param array $args Optional arguments
 */
function index(?array $args = []): void
{
  showView(getPageInfos(), 'contact', $args);
}

/**
 * Function to send contact request
 */
function sendContactRequest(): void
{
  $args = [];
  $formRules = getContactRules();
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // If no errors in the form data
  if (empty($errors)) {
    $destinataire = "ector.seb@gmail.com";
    $sujet = "Demande Renseignements";
    $message = "<html><body>";
    $message .= "<p> Nom: " . $valeursEchappees["lastName"] . " Prénom: " . $valeursEchappees["firstName"] . "</p>";
    $message .= "<p>adresse de contact: " . $valeursEchappees["email"] . "</p>";
    $message .= "<p>Message: " . $valeursEchappees["message"] . "</p>";
    $message .= "</body></html>";

    // If mail is sent successfully
    if (sendMail($destinataire, $sujet, $message)) {
      $args = [];
      $args["success"]["contact"] = "Le courriel a été envoyé avec succès.";
    } else {
      $args["error"]["contact"] = "Une erreur est survenue lors de l'envoi du courriel.";
    }
    index($args);
  } else {
    index($args);
  }
}
