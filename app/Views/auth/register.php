<?php
// define('BASE_URL', "/5xse1/projet_fin_annee");

// $pageTitre = "register";
// $metaDescription = "Formulaire d'enregistrement";
// require_once '../header.php';
// require_once '../formulaires.php';
// require_once '../auth.php'
?>



<div class="content">
  <div id="register">
    <h2>Register</h2>
    <form id="register-form" method="post">
      <div class="btn-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" value="<?= $valeursEchappees['pseudo'] ?? '' ?>" class="<?= !empty($errors["pseudo"]) ? 'is-invalid' : '' ?>">
      </div>
      <div class="btn-group">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?= $valeursEchappees['email'] ?? '' ?>" class="<?= !empty($errors["email"]) ? 'is-invalid' : '' ?>">
      </div>
      <div class="btn-group">
        <label for="password">Mot de passe</label>
        <input type="text" name="password" id="password" value="<?= $valeursEchappees['password'] ?? '' ?>" class="<?= !empty($errors["password"]) ? 'is-invalid' : '' ?>">
      </div>
      <div class="btn-group">
        <label for="passwordConfirm">Confirmer MDP</label>
        <input type="text" name="passwordConfirm" id="passwordConfirm" value="<?= $valeursEchappees['passwordConfirm'] ?? '' ?>" class="<?= !empty($errors["passwordConfirm"]) ? 'is-invalid' : '' ?>">
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
<!-- <?php require_once '../footer.php'; ?> -->