<?php
$inputClass = "rounded-md w-full p-2 pl-10 text-large text-gray-700 focus:outline-none focus:ring focus:ring-orange-500 ";
$editButtonClass = "edit-button  hover:text-orange-700 font-bold rounded";
$inputErrorClass = "ring ring-red-500";
$labelClass = "mb-1 font-semibold whitespace-nowrap ";

function isPasswordErrors($errors)
{
  if (isset($errors['passwordCurrent']) || isset($errors['passwordNew']) || isset($errors['passwordConfirm'])) {
    return true;
  }
  return false;
}
?>

<main class="relative h-screen">
  <div class="content">
    <div id="profile">
      <h2 class="text-4xl text-center mb-6">Mon Profil</h2>
      <div class="max-w-2xl mx-auto w-full border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">
        <form method="POST">

          <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">

          <div class="mb-4">
            <div class="flex flex-wrap text-lg gap-4">
              <label for="nom" class="<?= $labelClass ?>">Pseudo :</label>
              <div class="flex gap-4">
                <p><?= $user['usePseudo'] ?></p>
                <button id="edit-pseudo" class="<?= $editButtonClass ?>"><i class="fa-regular fa-pen-to-square"></i></button>
              </div>
            </div>
            <input id="input-pseudo" class="<?= $inputClass ?>  edit-input <?= isset($errors['pseudo']) ? $inputErrorClass . "" : 'hidden' ?>" type="text" name="pseudo" placeholder="<?= $user['usePseudo'] ?>" value="<?= isset($errors['pseudo']) ? $valeursEchappees['pseudo'] : null ?>">
            <?php if (!empty($errors["pseudo"])) { ?>
              <div id="error-pseudo" class="text-red-500"><?= $errors["pseudo"] ?></div>
            <?php } ?>
          </div>
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
              <div id="error-email" class="text-red-500"><?= $errors["email"] ?></div>
            <?php } ?>

          </div>
          <div class="mb-4">
            <div class="flex flex-wrap text-lg gap-4">
              <div class="flex gap-4">
                <label for="password" class="<?= $labelClass ?>">Mot de passe :</label>
                <p>********</p>
                <button id="edit-password" class="<?= $editButtonClass ?>"><i class="fa-regular fa-pen-to-square"></i></button>
              </div>
            </div>
            <div id="input-password" class="edit-input <?= isset($errors['password']) || isset($errors['passwordCurrent']) || isset($errors['passwordConfirm'])  ? "" : 'hidden' ?>">
              <!-- current password -->
              <label for="passwordCurrent" class="<?= $labelClass ?>">Mot de passe actuel:</label>
              <input id="input-passwordCurrent" type="password" name="passwordCurrent" class="password <?= $inputClass ?> <?= isset($errors['passwordCurrent']) ? $inputErrorClass : '' ?>" placeholder="********" value="<?= isset($errors) && isPasswordErrors($errors) ? $valeursEchappees['passwordCurrent'] : null ?>">
              <?php if (!empty($errors["passwordCurrent"])) { ?>
                <div id="error-passwordCurrent" class="text-red-500"><?= $errors["passwordCurrent"] ?></div>
              <?php } ?>
              <!-- new password -->
              <label for="passwordNew" class="<?= $labelClass ?>">Nouveau mot de passe:</label>
              <input id="input-passwordNew" type="password" name="passwordNew" class="password <?= $inputClass ?> <?= isset($errors['passwordNew']) ? $inputErrorClass : '' ?>" placeholder="********" value="<?= isset($errors) && isPasswordErrors($errors) ? $valeursEchappees['passwordNew'] : null ?>">
              <?php if (!empty($errors["passwordNew"])) { ?>
                <div id="error-passwordNew" class="text-red-500"><?= $errors["passwordNew"] ?></div>
              <?php } ?>
              <!-- confirm new password -->
              <label for="passwordConfirm" class="<?= $labelClass ?>">Confirmer le mot de passe:</label>
              <input id="input-passwordConfirm" type="password" name="passwordConfirm" class="password <?= $inputClass ?> <?= isset($errors['passwordConfirm']) ? $inputErrorClass : '' ?>" placeholder="********" value="<?= isset($errors) && isPasswordErrors($errors) ? $valeursEchappees['passwordConfirm'] : null ?>">
              <?php if (!empty($errors["passwordConfirm"])) { ?>
                <div id="error-passwordConfirm" class="text-red-500"><?= $errors["passwordConfirm"] ?></div>
              <?php } ?>
            </div>
          </div>
          <button id="edit-button" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded hidden" type="submit">Enregistrer les modifications</button>
        </form>
        <!-- <?php if (!empty($errors)) { ?>
      <ul class="error">
      <?php foreach ($errors as $key => $error) {
                  echo "<li class='text-red-500'> $error </li>";
                }
              } ?>
      </ul> -->
      </div>
    </div>
</main>

<script>
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

  const editButtons = document.querySelectorAll('.edit-button');
  editButtons.forEach((button, index) => {
    button.addEventListener('click', clickHandler);
  });
</script>