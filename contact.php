<?php
$pageTitre = "Contact";
$metaDescription = "Formulaire de contact";
require_once 'header.php';
require 'formulaires.php';
?>


<div class="content">
    <div id="contact">
        <h2>Contact</h2>
        <form id="contact-form" action="contact.php" method="post">
            <input type="hidden" name="formNom" value="formContact">
            <div class="btn-group">
                <label for="nom">Nom</label>
                <input type="text" class="<?= isset($errors["nom"]) ? 'is-invalid' : '' ?>" id="nom" name="nom" aria-describedby="email-erreur" aria-invalid="true">
            </div>
            <div class="btn-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="<?= isset($errors["prenom"]) ? 'is-invalid' : ''  ?>" id="prenom" name="prenom">
            </div>
            <div class="btn-group">
                <label for="email">Adresse email</label>
                <input type="email" class="<?= isset($errors["email"]) ? 'is-invalid' : ''  ?>" id="email" name="email">
            </div>
            <div class="btn-group">
                <label for="message">Message</label>
                <textarea class="<?= isset($errors["message"]) ? 'is-invalid' : ''  ?>" id="message" name="message"></textarea>
            </div>
            <?php if (!empty($errors)) {
                foreach ($errors as $key => $error) {
                    echo error($errors[$key]);
                }
            } ?>

            <button type="submit" class="">Envoyer</button>
        </form>
    </div>
</div>
<?php require_once 'footer.php'; ?>