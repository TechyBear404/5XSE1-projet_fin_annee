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

// function creer(?array $args = []): void
// {
//   // Appeler la vue.
//   showView(getPageInfos(), 'creer', $args);
// }

function sendContactRequest(): void
{
  // $args = [];
  $formRules = getRules();
  [$errors, $valeursEchappees] = verifChamps($formRules["errors"], $formRules["rules"], $_POST);
  $args["errors"] = $errors;
  $args["valeursEchappees"] = $valeursEchappees;

  // Appeler la vue.
  index($args);
}


function sendMail($valeursEchappees)
{
  $destinataire = "ector.seb@gmail.com";
  $sujet = "Demande Renseignements";
  $message = "<html><body>";
  $message .= "<p> Nom: " . $valeursEchappees["nom"] . " Prénom: " . $valeursEchappees["prenom"] . "</p>";
  $message .= "<p>adresse de contact: " . $valeursEchappees["email"] . "</p>";
  $message .= "<p>Message: " . $valeursEchappees["message"] . "</p>";
  $message .= "</body></html>";


  // Tentative d'envoi du mail (retourne "true" en cas de réussite et "false" en cas d'echec).
  if (mail($destinataire, $sujet, $message)) {
    echo "Le courriel a été envoyé avec succès.";
  } else {
    echo "L'envoi du courriel a échoué.";
  }
};
