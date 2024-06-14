<?php

function cleanInput($input)
{
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

function error($errors)
{
  ob_start();
?>
  <ul class="error">
    <?php foreach ($errors as $error) : ?>
      <li><?= $error ?></li>
    <?php endforeach; ?>
  </ul>
<?php
  $error = ob_get_clean();
  return $error;
}


function verifChamps($formRulesSettings, $formData)
{

  $formRules = $formRulesSettings["rules"];
  $formInputDisplay = $formRulesSettings["inputNames"];
  $formMessages = $formRulesSettings["errors"];

  $errors = [];
  $valeursEchappees = [];

  foreach ($formRules as $rule => $checks) {
    if (!isset($formData[$rule])) {
      $errors[$rule] = "Une erreur s'est produite lors de la soumission du formulaire.";
      break;
    }
    $cleanedData = cleanInput($formData[$rule]);
    $valeursEchappees[$rule] = $cleanedData;

    foreach ($checks as $check => $value) {
      if ($check === "required" && $value === true && (empty($cleanedData) || $cleanedData === "")) {
        $message = str_replace(["%0%"], [$formInputDisplay[$rule]], $formMessages["required"]);
        $errors[$rule] = $message;
        break;
      } elseif ($check === "minLength" && strlen($cleanedData) < $value) {
        $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$rule], $value], $formMessages["minLength"]);
        $errors[$rule] = $message;
      } elseif ($check === "maxLength" && strlen($cleanedData) > $value) {
        $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$rule], $value], $formMessages["maxLength"]);
        $errors[$rule] = $message;
      } elseif ($check === "type" && $value === "email") {
        if (!filter_var($cleanedData, FILTER_VALIDATE_EMAIL)) {
          $message = str_replace(["%0%"], [$formInputDisplay[$rule]], $formMessages["email"]);
          $errors[$rule] = $message;
        }
      } elseif ($check === "type" && $value === "passwordCurrent") {
        if (!isUserPassword($cleanedData)) {
          $errors[$rule] = "Votre mot de passe actuel est incorrect";
        }
      } elseif ($check === "type" && ($value === "password" || $value === "passwordNew")) {
        // if passworc contain min 8 characters, min 1 uppercase, min 1 lowercase and min 1 number
        if (!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', $cleanedData)) {
          $errors[$rule] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial @ $ ! % * ? &";
        }
      } elseif ($check === "type" && $value === "passwordConfirm") {
        if ($cleanedData !== $formData["password"]) {
          $errors[$rule] = "Les mots de passe ne correspondent pas";
        }
      } elseif ($check === "unique") {
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

  // foreach ($formData as $input => $value) {
  // $cleanedData = cleanInput($value);
  // $valeursEchappees[$input] = $cleanedData;

  //   foreach ($formRules[$input] as $rule => $value) {
  //     if ($rule === "type" && $value === "tokenCSRF") {
  //       echo '<pre>' . print_r($cleanedData, true) . '</pre>';
  //       if (!checkCSRF($cleanedData)) {
  //         $errors[$input] = "Une erreur s'est produite lors de la soumission du formulaire.";
  //         exit();
  //       }
  //     }
  //     if ($rule === "requis" && (empty($cleanedData) || $cleanedData === "")) {
  //       $message = str_replace(["%0%"], [$formInputDisplay[$input]], $formMessages["requis"]);
  //       $errors[$input] = $message;
  //       break;
  //     }
  //     if ($rule === "minLength" && strlen($cleanedData) < $value) {
  //       $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$input], $value], $formMessages["minLength"]);
  //       $errors[$input] = $message;
  //     }
  //     if ($rule === "maxLength" && strlen($cleanedData) > $value) {
  //       $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$input], $value], $formMessages["maxLength"]);
  //       $errors[$input] = $message;
  //     }
  //     if ($rule === "type" && $value === "email") {
  //       if (!filter_var($cleanedData, FILTER_VALIDATE_EMAIL)) {
  //         $message = str_replace(["%0%"], [$formInputDisplay[$input]], $formMessages["email"]);
  //         $errors[$input] = $message;
  //       }
  //     }
  //     if ($rule === "type" && $value === "password") {
  //       // if passworc contain at least 8 characters, one uppercase, one lowercase and one number
  //       if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\x21-\x7E]{8,}$/", $cleanedData)) {
  //         $errors[$input] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
  //       }
  //     }
  //     if ($rule === "type" && $value === "passwordConfirm") {
  //       if ($cleanedData !== $formData["password"]) {
  //         $errors[$input] = "Les mots de passe ne correspondent pas";
  //       }
  //     }
  //     if ($rule === "type" && $value === "passwordCurrent") {
  //       if (isUserPassword($cleanedData)) {
  //         $errors[$input] = "Les mots de passe ne correspondent pas";
  //       }
  //     }
  //   }
  // }
  return [$errors, $valeursEchappees];
}


  // foreach ($formRules as $nomChamp => $rules) {
  //   if ((isset($rules["minLength"]) || isset($rules["maxLength"])) && !empty($cleanedData)) {
  //     if (strlen($cleanedData) < $rules["minLength"]) {
  //       $message = str_replace(["%0%", "%1%"], [$nomChamp, $rules["minLength"]], $formMessages["minLength"]);
  //       $errors[$nomChamp] = $message;
  //     }
  //     if (strlen($cleanedData) > $rules["maxLength"]) {
  //       $message = str_replace(["%0%", "%1%"], [$nomChamp, $rules["maxLength"]], $formMessages["maxLength"]);
  //       $errors[$nomChamp] = $message;
  //     }
  //   }
  //   if (isset($rules["type"]) && !empty($cleanedData)) {
  //     if (!filter_var($cleanedData, FILTER_VALIDATE_EMAIL)) {
  //       $errors[$nomChamp] = $formMessages["email"];
  //     }
  //   }
  //   if (isset($rules["requis"])) {
  //     if (empty($cleanedData)) {
  //       $message = str_replace("%0%", $nomChamp, $formMessages["requis"]);
  //       $errors[$nomChamp] = $message;
  //     }
  //   }
  // }
  // echo '<pre>' . print_r($errors, true) . '</pre>';
  // echo '<pre>' . print_r($valeursEchappees, true) . '</pre>';


  // function sendMail($valeursEchappees)
  // {
  //   $destinataire = "ector.seb@gmail.com";
  //   $sujet = "Demande Renseignements";
  //   $message = "<html><body>";
  //   $message .= "<p> Nom: " . $valeursEchappees["nom"] . " Prénom: " . $valeursEchappees["prenom"] . "</p>";
  //   $message .= "<p>adresse de contact: " . $valeursEchappees["email"] . "</p>";
  //   $message .= "<p>Message: " . $valeursEchappees["message"] . "</p>";
  //   $message .= "</body></html>";


  //   // Tentative d'envoi du mail (retourne "true" en cas de réussite et "false" en cas d'echec).
  //   if (mail($destinataire, $sujet, $message)) {
  //     echo "Le courriel a été envoyé avec succès.";
  //   } else {
  //     echo "L'envoi du courriel a échoué.";
  //   }
  // };




  // if ($_SERVER["REQUEST_METHOD"] == "POST") {

  //   $formNom = $_POST["formNom"] ?? null;

  //   // if ($formNom === "formContact") {
  //   [$errors, $valeursEchappees] = verifChamps($formMessages, $formRules, $_POST);
  //   print_r($errors);
  //   if (empty($errors)) {
  //     sendMail($valeursEchappees);
  //     $valeursEchappees = [];
  //     $error = [];
  //   }
  //   // }
  // }