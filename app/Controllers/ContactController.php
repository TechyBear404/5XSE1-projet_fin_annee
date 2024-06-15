<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'contactModel.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'Mail.php';

$args = [];

// Communiquer les informations de la page nécessaire au bon fonctionnement de la vue :
function getPageInfos(): array
{
  return [
    'vue' => 'contact',
    'title' => "Page de contact",
    'description' => "Formulaire de contact.",
    'baseUrlPage' => BASE_URL . '/' . 'contact'
  ];
}

// index : Afficher la liste des utilisateurs (il s'agit de la partie chargée par défaut) :
function index(?array $args = []): void
{
  // Afficher la vue "vue_accueil.php".
  showView(getPageInfos(), 'contact', $args);
}

function sendContactRequest(): void
{
  // $args = [];
  $formRules = getContactRules();
  // echo '<pre>' . print_r($formRules, true) . '</pre>';
  [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // Si des erreurs sont survenues, on les affiche.
  if (empty($errors)) {

    $destinataire = "ector.seb@gmail.com";
    $sujet = "Demande Renseignements";
    $message = "<html><body>";
    $message .= "<p> Nom: " . $valeursEchappees["nom"] . " Prénom: " . $valeursEchappees["prenom"] . "</p>";
    $message .= "<p>adresse de contact: " . $valeursEchappees["email"] . "</p>";
    $message .= "<p>Message: " . $valeursEchappees["message"] . "</p>";
    $message .= "</body></html>";


    // Tentative d'envoi du mail (retourne "true" en cas de réussite et "false" en cas d'echec).
    $args = [];
    if (sendMail($destinataire, $sujet, $message)) {
      $args["message"]["success"] = "Le courriel a été envoyé avec succès.";
    } else {
      $args["message"]["error"] = "Une erreur est survenue lors de l'envoi du courriel.";
    }
    index($args);
  } else {
    index($args);
  }
};
