<?php
// Define CSS classes for inputs, edit buttons, and error inputs
$inputClass = "rounded-md w-full p-2 pl-10 text-large text-gray-700 focus:outline-none focus:ring focus:ring-orange-500";
$editButtonClass = "edit-button  hover:text-orange-700 font-bold rounded";
$inputErrorClass = "ring ring-red-500";
$labelClass = "mb-1 font-semibold whitespace-nowrap";

// Function to check if there are password errors
function isPasswordErrors($errors)
{
  if (isset($errors['passwordCurrent']) || isset($errors['passwordNew']) || isset($errors['passwordConfirm'])) {
    return true;
  }
  return false;
}
?>

<!-- Profile page main content -->
<main class="relative  min-h-screen">
  <!-- Section for displaying error or success messages -->
  <section class="absolute top-0 w-full">
    <?php if (isset($errors['profile'])) { ?>
      <!-- Display error message if activation error occurs -->
      <p class="text-white font-bold text-center p-2 bg-red-400 header-info transition-all duration-500 opacity-100"><?= $errors['profile'] ?></p>
    <?php } ?>
    <?php if (isset($success['profile'])) { ?>
      <!-- Display success message if activation is successful -->
      <p class="text-white font-bold text-center p-2 bg-green-400 header-info transition-all duration-500 opacity-100"><?= $success['profile'] ?></p>
    <?php } ?>
  </section>
  <div class="content">
    <div id="profile">
      <h2 class="text-4xl text-center mb-6">Mon Profil</h2>
      <div class="max-w-2xl mx-auto w-full border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">
        <form method="POST">
          <!-- CSRF token -->
          <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">

          <!-- Pseudo input -->
          <div class="mb-4">
            <div class="flex flex-wrap text-lg gap-4">
              <label for="nom" class="<?= $labelClass ?>">Pseudo :</label>
              <div class="flex gap-4">
                <p><?= $user['usePseudo'] ?></p>
                <button id="edit-pseudo" class="<?= $editButtonClass ?>"><i class="fa-regular fa-pen-to-square"></i></button>
              </div>
            </div>
            <input id="input-pseudo" class="<?= $inputClass ?>  edit-input <?= isset($errors['pseudo']) ? $inputErrorClass . "" : 'hidden' ?>" type="text" name="pseudo" placeholder="<?= $user['usePseudo'] ?>" value="<?= isset($errors['pseudo']) ? $valeursEchappees['pseudo'] : null ?>" min="2" max="16">

            <?php if (!empty($errors["pseudo"])) { ?>
              <!-- Display pseudo error message -->
              <div id="error-pseudo" class="text-red-500"><?= $errors["pseudo"] ?></div>
            <?php } ?>
          </div>

          <!-- Email input -->
          <div class="mb-4">
            <div class="flex flex-wrap text-lg gap-4">
              <label for="email" class="<?= $labelClass ?>">Adresse e-mail :</label>
              <div class="flex gap-4">
                <p><?= $user['useEmail'] ?></p>
                <button id="edit-email" class="<?= $editButtonClass ?>"><i class="fa-regular fa-pen-to-square"></i></button>
              </div>
            </div>
            <input id="input-email" class="<?= $inputClass ?>  edit-input <?= isset($errors['email']) ? $inputErrorClass : 'hidden' ?>" type="email" name="email" placeholder="<?= $user['useEmail'] ?>" value="<?= isset($errors['email']) ? $valeursEchappees['email'] : null ?>">

            <?php if (!empty($errors["email"])) { ?>
              <!-- Display email error message -->
              <div id="error-email" class="text-red-500"><?= $errors["email"] ?></div>
            <?php } ?>
          </div>

          <!-- Password input -->
          <div class="mb-4">
            <div class="flex flex-wrap text-lg gap-4">
              <div class="flex gap-4">
                <label for="password" class="<?= $labelClass ?>">Mot de passe :</label>
                <p>********</p>
                <button id="edit-password" class="<?= $editButtonClass ?>"><i class="fa-regular fa-pen-to-square"></i></button>
              </div>
            </div>
            <div id="input-password" class="edit-input <?= isset($errors['password']) || isset($errors['passwordCurrent']) || isset($errors['passwordConfirm'])  ? "" : 'hidden' ?>">
              <!-- Current password input -->
              <label for="passwordCurrent" class="<?= $labelClass ?>">Mot de passe actuel:</label>
              <input id="input-passwordCurrent" type="password" name="passwordCurrent" class="password <?= $inputClass ?> <?= isset($errors['passwordCurrent']) ? $inputErrorClass : '' ?>" placeholder="********" value="<?= isset($errors) && isPasswordErrors($errors) ? $valeursEchappees['passwordCurrent'] : null ?>" min="2" max="32">

              <?php if (!empty($errors["passwordCurrent"])) { ?>
                <!-- Display password current error message -->
                <div id="error-passwordCurrent" class="text-red-500"><?= $errors["passwordCurrent"] ?></div>
              <?php } ?>

              <!-- New password input -->
              <label for="passwordNew" class="<?= $labelClass ?>">Nouveau mot de passe:</label>
              <input id="input-passwordNew" type="password" name="passwordNew" class="password <?= $inputClass ?> <?= isset($errors['passwordNew']) ? $inputErrorClass : '' ?>" placeholder="********" value="<?= isset($errors) && isPasswordErrors($errors) ? $valeursEchappees['passwordNew'] : null ?>" min="2" max="32">

              <?php if (!empty($errors["passwordNew"])) { ?>
                <!-- Display password new error message -->
                <div id="error-passwordNew" class="text-red-500"><?= $errors["passwordNew"] ?></div>
              <?php } ?>

              <!-- Confirm new password input -->
              <label for="passwordConfirm" class="<?= $labelClass ?>">Confirmer le mot de passe:</label>
              <input id="input-passwordConfirm" type="password" name="passwordConfirm" class="password <?= $inputClass ?> <?= isset($errors['passwordConfirm']) ? $inputErrorClass : '' ?>" placeholder="********" value="<?= isset($errors) && isPasswordErrors($errors) ? $valeursEchappees['passwordConfirm'] : null ?>" min="2" max="32">

              <?php if (!empty($errors["passwordConfirm"])) { ?>
                <!-- Display password confirm error message -->
                <div id="error-passwordConfirm" class="text-red-500"><?= $errors["passwordConfirm"] ?></div>
              <?php } ?>
            </div>

            <!-- Save changes button -->
            <button id="edit-button" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded hidden" type="submit">Enregistrer les modifications</button>
        </form>
      </div>
    </div>
  </div>
</main>

<script>
  // Function to check if edit inputs are hidden
  function isHidden() {
    const editInputs = document.querySelectorAll('.edit-input');
    let isHidden = true;
    editInputs.forEach((input, index) => {
      if (!input.classList.contains('hidden')) {
        isHidden = false;
      }
    });
    if (isHidden) {
      document.getElementById('edit-button').classList.add('hidden');
    } else {
      document.getElementById('edit-button').classList.remove('hidden');
    }
  }

  isHidden();

  // Click handler for edit buttons
  const clickHandler = (event) => {
    event.preventDefault();
    const editInput = document.getElementById(event.target.parentElement.id.replace('edit-', 'input-'));
    const passwordInputs = document.querySelectorAll('.password');
    const errorInput = document.getElementById(event.target.parentElement.id.replace('edit-', 'error-'));
    editInput.classList.toggle('hidden');
    if (editInput.classList.contains('hidden') && event.target.parentElement.id !== 'edit-password') {
      editInput.value = null;
      editInput.classList.remove('ring');
      editInput.classList.remove('ring-red-500');
      errorInput.innerText = null;
    } else if (editInput.classList.contains('hidden') && event.target.parentElement.id === 'edit-password') {
      console.log('password');
      passwordInputs.forEach((input, index) => {
        const errorPassword = document.getElementById(input.id.replace('input-', 'error-'));
        input.value = null;
        input.classList.remove('ring');
        input.classList.remove('ring-red-500');
        errorPassword.innerText = null;
      });
    }
    isHidden();
  }

  // Add event listener to edit buttons
  const editButtons = document.querySelectorAll('.edit-button');
  editButtons.forEach((button, index) => {
    button.addEventListener('click', clickHandler);
  });

  const headerInfo = document.querySelector('.header-info');
  if (headerInfo) {
    // Hide the header info after 3 seconds
    setTimeout(() => {
      headerInfo.classList.remove('opacity-100');
      headerInfo.classList.add('opacity-0');
      setTimeout(() => {
        headerInfo.style.display = 'none';
      }, 500);
    }, 3000);
  }
</script>