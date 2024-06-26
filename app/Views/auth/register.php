<?php
// Define CSS classes for form elements
$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-slate-950 py-1 px-2 focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-blue-800 rounded-md border-white border font-bold shadow-md mt-6 py-1 px-4 w-24 mx-auto text-white hover:bg-blue-500 hover:w-28 hover:shadow-lg transition-all duration-300 ease-in-out";
?>


<!-- Main content area -->
<main class="relative  min-h-screen">
  <section class="absolute top-0 w-full">
    <?php
    // Display registration errors or success messages
    if (isset($errors['registration'])) { ?>
      <p class="text-white font-bold text-center p-2 bg-red-400 header-info transition-all duration-500 opacity-100"><?= $errors['registration'] ?></p>
    <?php } elseif (isset($success['registration'])) { ?>
      <p class="text-white font-bold text-center p-2 bg-green-400 header-info transition-all duration-500 opacity-100"><?= $success['registration'] ?></p>
    <?php } ?>
  </section>
  <div class="content">
    <div id="register">
      <h2 class="text-4xl text-center mb-6">Enregistre toi!</h2>
      <div class="flex flex-col max-w-xs mx-auto border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">
        <form id="register-form" class="flex flex-col" method="post">
          <!-- CSRF token input -->
          <input type="hidden" name="tokenCSRF" value="<?php echo $_SESSION['tokenCSRF'] ?>">

          <!-- Pseudo input field -->
          <label class="<?= $labelClass ?>" for="pseudo">Pseudo</label>
          <input class="<?= $inputClass ?> <?= !empty($errors["pseudo"]) ? $inputErrorClass : '' ?>" type="text" name="pseudo" id="pseudo" value="<?= $valeursEchappees['pseudo'] ?? '' ?>" min="2" max="16" required>
          <?php if (!empty($errors["pseudo"])) { ?>
            <div class="text-red-500"><?= $errors["pseudo"] ?></div>
          <?php } ?>

          <!-- Email input field -->
          <label class="<?= $labelClass ?>" for="email">Email</label>
          <input class="<?= $inputClass ?> <?= !empty($errors["email"]) ? $inputErrorClass : '' ?>" type="text" name="email" id="email" value="<?= $valeursEchappees['email'] ?? '' ?>" required>
          <?php if (!empty($errors["email"])) { ?>
            <div class="text-red-500"><?= $errors["email"] ?></div>
          <?php } ?>

          <!-- Password input field -->
          <label class="<?= $labelClass ?>" for="password">Mot de passe</label>
          <input class="<?= $inputClass ?> <?= !empty($errors["password"]) ? $inputErrorClass : '' ?>" type="password" name="password" id="password" value="<?= $valeursEchappees['password'] ?? '' ?>" min="8" max="32" required>
          <?php if (!empty($errors["password"])) { ?>
            <div class="text-red-500"><?= $errors["password"] ?></div>
          <?php } ?>

          <!-- Password confirmation input field -->
          <label class="<?= $labelClass ?>" for="passwordConfirm">Confirmer MDP</label>
          <input class="<?= $inputClass ?> <?= !empty($errors["passwordConfirm"]) ? $inputErrorClass : '' ?>" type="password" name="passwordConfirm" id="passwordConfirm" value="<?= $valeursEchappees['passwordConfirm'] ?? '' ?>" min="8" max="32" required>
          <?php if (!empty($errors["passwordConfirm"])) { ?>
            <div class="text-red-500"><?= $errors["passwordConfirm"] ?></div>
          <?php } ?>

          <!-- Submit button -->
          <button type="submit" class="<?= $buttonClass ?>"><span>Envoyer</span></button>
        </form>
      </div>
    </div>
  </div>
</main>

<!-- JavaScript code to animate and hide error/success messages -->
<script>
  const headerInfo = document.querySelector('.header-info');
  if (headerInfo) {
    setTimeout(() => {
      headerInfo.classList.remove('opacity-100');
      headerInfo.classList.add('opacity-0');
      setTimeout(() => {
        headerInfo.style.display = 'none';
      }, 500);
    }, 3000);
  }
</script>