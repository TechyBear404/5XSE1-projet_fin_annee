<?php
$pageTitre = "Contact";
$metaDescription = "Formulaire de contact";
// require_once 'header.php';
// require 'formulaires.php';
?>


<div class="content">
    <div id="contact">
        <h2>Contact</h2>
        <form id="contact-form" method="post">
            <!-- <input type="hidden" name="formNom" value="formContact"> -->
            <div class="btn-group">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" value="<?= $args['valeursEchappees']['nom'] ?? '' ?>" class="<?= !empty($errors["nom"]) ? 'is-invalid' : '' ?>">
            </div>
            <div class="btn-group">
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" id="prenom" value="<?= $args['valeursEchappees']['prenom'] ?? '' ?>" class="<?= !empty($errors["prenom"]) ? 'is-invalid' : '' ?>">
            </div>
            <div class="btn-group">
                <label for="email">Adresse email</label>
                <input type="text" name="email" id="email" value="<?= $args['valeursEchappees']['email'] ?? '' ?>" class="<?= !empty($errors["email"]) ? 'is-invalid' : '' ?>">
            </div>
            <div class="btn-group">
                <label for="message">Message</label>
                <!-- <input type="text" name="email" id="email" value="<?= $args['valeursEchappees']['email'] ?? '' ?>" class=""> -->
                <textarea name="message" id="message" class="<?= !empty($errors["message"]) ? 'is-invalid' : '' ?>" cols="30" rows="10"><?= $args['valeursEchappees']['message'] ?? '' ?></textarea>
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
<!-- <?php require_once 'footer.php'; ?> -->