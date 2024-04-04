<?php
// define('BASE_URL', "/5xse1/projet_fin_annee");

$pageTitre = "Login";
$metaDescription = "Formulaire de connection";
require_once '../header.php';
require_once '../formulaires.php';
require_once '../utils/auth.php'
?>



<div class="content">
  <div id="login">
    <h2>Login</h2>
    <form id="login-form" action="/auth/login.php" method="post">
      <div class="btn-group">
        <label for="pseudo">Pseudo</label>
        <?= inputElem("input", "text", "pseudo", "pseudo", isset($errors["pseudo"]), $valeursEchappees["pseudo"] ?? null)  ?>
      </div>
      <div class="btn-group">
        <label for="pwd">Mot de passe</label>
        <?= inputElem("input", "text", "pwd", "pwd", isset($errors["pwd"]), null)  ?>
      </div>

      <?php if (!empty($errors)) { ?>
        <ul class="error">
        <?php foreach ($errors as $key => $error) {
          echo "<li> $error </li>";
        }
      } ?>
        </ul>

        <button type="submit" class="">Envoyer</button>
    </form>
    <div id="alertPopup">

    </div>
  </div>
</div>
<?php require_once '../footer.php'; ?>