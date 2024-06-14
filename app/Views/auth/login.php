<?php
// require_once '../formulaires.php';
// require_once '../utils/auth.php'
// require_once dirname(__DIR__, 3) . DS . 'core' . DS . 'Session.php';

$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-gray-700 py-1 px-2  focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-orange-600 rounded-md flex justify-center border-white border font-bold shadow-sm mt-6 py-1 px-4 mx-auto text-white hover:bg-orange-500 hover:shadow-md hover:shadow-orange-500 transition-all duration-300 ease-in-out";
$tokenCSRF = generateCSRF();
?>



<div class="content">
  <div id="login">
    <h2 class="text-4xl text-center mb-6">Login</h2>
    <div class=" max-w-xs mx-auto border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">


      <?php if (!empty($errors["activation"])) { ?>
        <form method="POST">
          <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">
          <input type="hidden" name="type" value="activation">
          <div id="error-activation" class="text-red-500 text-center mb-4 "><?= $errors["activation"] ?></div>
          <!-- button to resend activation -->
          <button id="resend-activation" class="<?= $buttonClass ?>"><span>Renvoyer</span></button>
        </form>
      <?php } ?>
      <form id="login-form" class="flex flex-col" method="POST">

        <input type="hidden" name="tokenCSRF" value="<?php echo $tokenCSRF ?>">
        <input type="hidden" name="type" value="login">


        <label class="<?= $labelClass ?>" for="pseudo">Email</label>
        <input class="<?= $inputClass ?> <?= isset($errors['email']) ? $inputErrorClass : '' ?>" type="mail" name="email" id="pseudo" value="<?= $args['valeursEchappees']['email'] ?? '' ?>">
        <?php if (!empty($errors["email"])) { ?>
          <div class="text-red-500"><?= $errors["email"] ?></div>
        <?php } ?>

        <label class="<?= $labelClass ?>" for="password">Mot de passe</label>
        <input class="<?= $inputClass ?> <?= isset($errors['password']) ? $inputErrorClass : '' ?>" type="password" name="password" id="password" value="<?= $args['valeursEchappees']['password'] ?? '' ?>">
        <?php if (!empty($errors["password"])) { ?>
          <div class="text-red-500"><?= $errors["password"] ?></div>
        <?php } ?>

        <button type="submit" class="<?= $buttonClass ?>"><span>Se connecter</span></button>
      </form>
    </div>
    <div id="alertPopup">

    </div>
  </div>
</div>