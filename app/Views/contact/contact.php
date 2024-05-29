<?php
$pageTitre = "Contact";
$metaDescription = "Formulaire de contact";
// require_once 'header.php';
// require 'formulaires.php';
?>


<div class="content mt-10">
    <div id="contact">
        <h2 class="text-4xl text-center mb-6">Contact</h2>
        <form id="contact-form" method="post">
            <!-- <input type="hidden" name="formNom" value="formContact"> -->
            <div class="btn-group">
                <label for="firstName">Prénom</label>
                <input type="text" name="firstName" id="firstName" value="<?= $args['valeursEchappees']['firstName'] ?? '' ?>" class="<?= !empty($errors["firstName"]) ? 'is-invalid' : '' ?> text-black">
            </div>
            <div class="btn-group">
                <label for="lastName">Nom</label>
                <input type="text" name="lastName" id="lastName" value="<?= $args['valeursEchappees']['lastName'] ?? '' ?>" class="<?= !empty($errors["lastName"]) ? 'is-invalid' : '' ?> text-black">
            </div>
            <div class="btn-group">
                <label for="email">Adresse email</label>
                <input type="text" name="email" id="email" value="<?= $args['valeursEchappees']['email'] ?? '' ?>" class="<?= !empty($errors["email"]) ? 'is-invalid' : '' ?> text-black">
            </div>
            <div class="btn-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" class="<?= !empty($errors["message"]) ? 'is-invalid' : '' ?> text-black" cols="" rows="10"><?= $args['valeursEchappees']['message'] ?? '' ?></textarea>
            </div>
            <?php if (!empty($errors)) { ?>
                <ul class="error">
                <?php foreach ($errors as $key => $error) {
                    echo "<li> $error </li>";
                }
            } ?>
                </ul>

                <button type="submit" class="bg-blue-700 px-4 py-1 rounded-md hover:bg-blue-600">Envoyer</button>
        </form>
        <div id="alertPopup">

        </div>
    </div>
</div>
<!-- <?php require_once 'footer.php'; ?> -->