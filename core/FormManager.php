<?php

// Function to clean user input data
function cleanInput($input)
{
  $input = trim($input);  // Remove whitespace from the beginning and end
  $input = stripslashes($input);  // Remove backslashes from the input
  $input = htmlspecialchars($input);  // Convert special characters to HTML entities
  return $input;
}

// Function to display error messages
function error($errors)
{
  ob_start();  // Start output buffering
?>
  <!-- Display errors as an unordered list -->
  <ul class="error">
    <?php foreach ($errors as $error) : ?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php
  $error = ob_get_clean();  // Get the output buffer contents and delete the buffer
  return $error;
}

// Function to verify form data based on predefined rules
function verifChamps($formRulesSettings, $formData)
{
  // Extract rules, input names, and error messages from the settings
  $formRules = $formRulesSettings["rules"];
  $formInputDisplay = $formRulesSettings["inputNames"];
  $formMessages = $formRulesSettings["errors"];

  $errors = [];  // Initialize an array to store error messages
  $valeursEchappees = [];  // Initialize an array to store cleaned input data

  // Loop through each form rule
  foreach ($formRules as $rule => $checks) {
    if (!isset($formData[$rule])) {
      $errors[$rule] = "Une erreur s'est produite lors de la soumission du formulaire.";
      break;
    }

    // Clean the input data
    $cleanedData = cleanInput($formData[$rule]);
    $valeursEchappees[$rule] = $cleanedData;

    // Loop through each check for the current rule
    foreach ($checks as $check => $value) {
      // Perform different checks based on the type of check
      if ($check === "required" && $value === true && (empty($cleanedData) || $cleanedData === "")) {
        // Check if the input is required and not empty
        $message = str_replace(["%0%"], [$formInputDisplay[$rule]], $formMessages["required"]);
        $errors[$rule] = $message;
        break;
      } elseif ($check === "minLength" && strlen($cleanedData) < $value) {
        // Check if the input is at least a certain length
        $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$rule], $value], $formMessages["minLength"]);
        $errors[$rule] = $message;
      } elseif ($check === "maxLength" && strlen($cleanedData) > $value) {
        // Check if the input is not longer than a certain length
        $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$rule], $value], $formMessages["maxLength"]);
        $errors[$rule] = $message;
      } elseif ($check === "type" && $value === "email") {
        // Check if the input is a valid email address
        if (!filter_var($cleanedData, FILTER_VALIDATE_EMAIL)) {
          $message = str_replace(["%0%"], [$formInputDisplay[$rule]], $formMessages["email"]);
          $errors[$rule] = $message;
        }
      } elseif ($check === "type" && $value === "passwordCurrent") {
        // Check if the input is the current password
        if (!isUserPassword($cleanedData)) {
          $errors[$rule] = "Votre mot de passe actuel est incorrect";
        }
      } elseif ($check === "type" && ($value === "password" || $value === "passwordNew")) {
        // Check if the input is a valid password (at least 8 characters, uppercase, lowercase, number, and special character)
        if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $cleanedData)) {
          $errors[$rule] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial @ $ ! % * ? &";
        }
      } elseif ($check === "type" && $value === "passwordConfirm") {
        // Check if the input matches the password or new password
        if ((isset($formData["password"]) && $cleanedData !== $formData["password"]) || (isset($formData["passwordNew"]) && $cleanedData !== $formData["passwordNew"])) {
          $errors[$rule] = "Les mots de passe ne correspondent pas";
        }
      } elseif ($check === "unique") {
        // Check if the input is unique (e.g. email or username)
        if ($value === "email") {
          if (isEmailUsed($cleanedData)) {
            $errors[$rule] = "L'adresse email est déjà utilisée";
          }
        } elseif ($value === "user") {
          if (isPseudoUsed($cleanedData)) {
            $errors[$rule] = "Le pseudo est déjà utilisé";
          }
        }
      }
    }
  }

  // Return an array containing error messages and cleaned input data
  return [$errors, $valeursEchappees];
}
