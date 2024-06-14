<?php
// require_once '../formulaires.php';
// require_once '../utils/auth.php'
// require_once dirname(__DIR__, 3) . DS . 'core' . DS . 'Session.php';

$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-gray-700 py-1 px-2  focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-orange-500 rounded-md border-white border font-bold shadow-md mt-6 py-1 px-4 w-24 mx-auto text-white hover:bg-orange-700 hover:w-28 hover:shadow-lg transition-all duration-300 ease-in-out";
$tokenCSRF = generateCSRF();
?>



<div class="content">
  <div id="login">
    <h2 class="text-4xl text-center mb-6">Login</h2>
    <form id="login-form" class="flex flex-col max-w-xs mx-auto border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500" method="POST">

      <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">

      <label class="<?= $labelClass ?>" for="pseudo">Pseudo</label>
      <input class="<?= $inputClass ?> <?= isset($errors['pseudo']) ? $inputErrorClass : '' ?>" type="text" name="pseudo" id="pseudo" value="<?= $args['valeursEchappees']['pseudo'] ?? '' ?>">
      <?php if (!empty($errors["pseudo"])) { ?>
        <div class="text-red-500"><?= $errors["pseudo"] ?></div>
      <?php } ?>

      <label class="<?= $labelClass ?>" for="password">Mot de passe</label>
      <input class="<?= $inputClass ?> <?= isset($errors['password']) ? $inputErrorClass : '' ?>" type="password" name="password" id="password" value="<?= $args['valeursEchappees']['password'] ?? '' ?>">
      <?php if (!empty($errors["password"])) { ?>
        <div class="text-red-500"><?= $errors["password"] ?></div>
      <?php } ?>

      <button type="submit" class="<?= $buttonClass ?>"><span>Envoyer</span></button>
    </form>
    <div id="alertPopup">

    </div>
  </div>
</div>