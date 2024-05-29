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

// function inputElem($tag, $type, $id, $name, $isError, $escapedValue)
// {
//   $inputValue = $escapedValue != null ? $escapedValue : '';
//   $errorElem = !$isError ?  ' aria-invalid="false">' : ' class="is-invalid" aria-invalid="true">';
//   if ($tag === "input") {
//     return '<input type="' . $type .  'id="' . $id . '" name="' . $name . '" value="' . $inputValue . '"' . $errorElem;
//   } else if ($tag === "textarea") {
//     return '<textarea id="' . $id . '" name="' . $name . '"' . $errorElem . $inputValue . '</textarea>';
//   }
// }

// $formRules = [
//   'nom' => [
//     'requis' => true,
//     'minLength' => 2,
//     'maxLength' => 255,
//   ],
//   'prenom' => [
//     'minLength' => 2,
//     'maxLength' => 255,
//   ],
//   'email' => [
//     'requis' => true,
//     'type' => "email",
//   ],
//   'message' => [
//     'requis' => true,
//     'minLength' => 10,
//     'maxLength' => 3000,
//   ],
// ];

// $formMessages = [
//   "requis" => "Le champ %0% est requis",
//   "email" => "Veuillez entrer une adresse mail valide",
//   "minLength" => "Le champ %0% doit contenir au moins %1% caractères",
//   "maxLength" => "Le champ %0% doit contenir au maximum %1% caractères",
//   "envoiEchec" => "le formulaire n'a pas été envoyé!",
//   "envoiSucces" => "le formulaire a bien été envoyé!"
// ];


function verifChamps($formRulesSettings, $formData)
{

  $formRules = $formRulesSettings["rules"];
  $formInputDisplay = $formRulesSettings["inputNames"];
  $formMessages = $formRulesSettings["errors"];

  $errors = [];
  $valeursEchappees = [];

  foreach ($formData as $input => $value) {
    $cleanedData = cleanInput($value);
    $valeursEchappees[$input] = $cleanedData;

    foreach ($formRules[$input] as $rule => $value) {
      if ($rule === "requis" && (empty($cleanedData) || $cleanedData === "")) {
        $message = str_replace(["%0%"], [$formInputDisplay[$input]], $formMessages["requis"]);
        $errors[$input] = $message;
        break;
      }
      if ($rule === "minLength" && strlen($cleanedData) < $value) {
        $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$input], $value], $formMessages["minLength"]);
        $errors[$input] = $message;
      }
      if ($rule === "maxLength" && strlen($cleanedData) > $value) {
        $message = str_replace(["%0%", "%1%"], [$formInputDisplay[$input], $value], $formMessages["maxLength"]);
        $errors[$input] = $message;
      }
      if ($rule === "type" && $value === "email") {
        if (!filter_var($cleanedData, FILTER_VALIDATE_EMAIL)) {
          $message = str_replace(["%0%"], [$formInputDisplay[$input]], $formMessages["email"]);
          $errors[$input] = $message;
        }
      }
      if ($rule === "type" && $value === "password") {
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $cleanedData)) {
          $errors[$input] = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre";
        }
      }
      if ($rule === "type" && $value === "passwordConfirm") {

        if ($cleanedData !== $formData["password"]) {
          $errors[$input] = "Les mots de passe ne correspondent pas";
        }
      }
    }
  }
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