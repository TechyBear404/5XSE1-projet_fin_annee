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
                <?= inputElem("input", "text", "nom", "nom", isset($errors["nom"]), $valeursEchappees["nom"] ?? null)  ?>
            </div>
            <div class="btn-group">
                <label for="prenom">Prénom</label>
                <?= inputElem("input", "text", "prenom", "prenom", isset($errors["prenom"]), $valeursEchappees["prenom"] ?? null)  ?>
            </div>
            <div class="btn-group">
                <label for="email">Adresse email</label>
                <?= inputElem("input", "text", "email", "email", isset($errors["email"]), $valeursEchappees["email"] ?? null)  ?>
            </div>
            <div class="btn-group">
                <label for="message">Message</label>
                <?= inputElem("textarea", "textarea", "message", "message", isset($errors["message"]), $valeursEchappees["message"] ?? null)  ?>
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
<?php require_once 'footer.php'; ?>