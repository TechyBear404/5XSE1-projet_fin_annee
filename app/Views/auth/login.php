<?php
// Define CSS classes for labels, inputs, input errors, and buttons
$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-gray-700 py-1 px-2 focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-orange-600 rounded-md flex justify-center border-white border font-bold shadow-sm mt-6 py-1 px-4 mx-auto text-white hover:bg-orange-500 hover:shadow-md hover:shadow-orange-500 transition-all duration-300 ease-in-out";
?>

<!-- Main layout container -->
<main class="relative h-full">
  <!-- Section for displaying error or success messages -->
  <section class="absolute top-0 w-full">
    <?php if (isset($errors['activation'])) { ?>
      <!-- Display error message if activation error occurs -->
      <p class="text-white font-bold text-center p-2 bg-red-400 header-info transition-all duration-500 opacity-100"><?= $errors['activation'] ?></p>
    <?php } ?>
    <?php if (isset($success['activation'])) { ?>
      <!-- Display success message if activation is successful -->
      <p class="text-white font-bold text-center p-2 bg-green-400 header-info transition-all duration-500 opacity-100"><?= $success['activation'] ?></p>
    <?php } ?>
  </section>

  <!-- Content container -->
  <div class="content">
    <div id="login">
      <!-- Login form header -->
      <h2 class="text-4xl text-center mb-6">Login</h2>

      <!-- Login form container -->
      <div class="flex flex-col max-w-xs mx-auto border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">

        <!-- Login form -->
        <form id="login-form" class="flex flex-col" method="POST">
          <!-- CSRF token hidden input -->
          <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">
          <!-- Form type (login) hidden input -->
          <input type="hidden" name="type" value="login">

          <!-- Email input field -->
          <label class="<?= $labelClass ?>" for="email">Email</label>
          <input class="<?= $inputClass ?> <?= isset($errors['email']) ? $inputErrorClass : '' ?>" type="email" name="email" id="email" value="<?= $args['valeursEchappees']['email'] ?? '' ?>">
          <?php if (!empty($errors["email"])) { ?>
            <!-- Display email error message if any -->
            <div class="text-red-500"><?= $errors["email"] ?></div>
          <?php } ?>

          <!-- Password input field -->
          <label class="<?= $labelClass ?>" for="password">Mot de passe</label>
          <input class="<?= $inputClass ?> <?= isset($errors['password']) ? $inputErrorClass : '' ?>" type="password" name="password" id="password" value="<?= $args['valeursEchappees']['password'] ?? '' ?>">
          <?php if (!empty($errors["password"])) { ?>
            <!-- Display password error message if any -->
            <div class="text-red-500"><?= $errors["password"] ?></div>
          <?php } ?>

          <!-- Login button -->
          <button type="submit" class="<?= $buttonClass ?>"><span>Se connecter</span></button>
        </form>
      </div>

      <!-- Alert popup container -->
      <div id="alertPopup">

      </div>
    </div>
  </div>
</main>

<script>
  // JavaScript code to animate and hide error/success messages
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