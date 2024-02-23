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

function checkLength($input, $name, $min, $max)
{
  if (strlen($input) < $min) {
    return "Le champ $name doit contenir au moins $min caractères";
  }
  if (strlen($input) > $max) {
    return "Le champ $name doit contenir moins de $max caractères";
  }
  return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // $nom = $_POST["nom"];
  // $nom = htmlentities($_POST["nom"]);
  // echo $nom;
  // echo "<script>" . $nom . "</script>";

  $formNom = $_POST["formNom"] ?? null;

  $nom = cleanInput($_POST["nom"]);
  $prenom = cleanInput($_POST["prenom"]);
  $email = cleanInput($_POST["email"]);
  $message = cleanInput($_POST["message"]);
  $errors = [];

  if ($formNom === "formContact") {

    if (empty($nom)) {
      $errors["nom"][] = "Veuillez remplir les champs obligatoires";
    } else {
      $length = checkLength($nom, "nom", 2, 255);
      if ($length) {
        $errors["nom"][] = $length;
      }
    }

    if (!empty($prenom)) {
      $validLength = checkLength($prenom, "prénom", 2, 255);
      if ($validLength) {
        $errors["prenom"][] = $validLength;
      }
    }
  }
}
