<?php
// require_once '../formulaires.php';
// require_once '../utils/auth.php'
?>



<div class="content">
  <div id="login">
    <h2 class="text-4xl text-center mb-6">Login</h2>
    <form id="login-form" method="POST">
      <div class="btn-group">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo" value="<?= $args['valeursEchappees']['pseudo'] ?? '' ?>" class="<?= isset($args['errors']['pseudo']) ? 'is-invalid' : '' ?>">
      </div>
      <div class="btn-group">
        <label for="password">Mot de passe</label>
        <input type="text" name="password" id="password" value="<?= $args['valeursEchappees']['password'] ?? '' ?>" class="<?= isset($args['errors']['password']) ? 'is-invalid' : '' ?>">
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