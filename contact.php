<?php 
$pageTitre = "Contact";
$metaDescription = "Formulaire de contact";
require_once 'header.php';
?>
<div id="contact" class="content">
    <div>
        <h2>Contact</h2>
        <form id="contact-form" action="contact.php" method="post">
            <div class="btn-group">
                <label for="nom">Nom</label>
                <input type="text" class="" id="nom" name="nom" minlength="2" maxlentgh="255" required>
    
                <label for="prenom">Prénom</label>
                <input type="text" class="" id="prenom" name="prenom"  minlength="2" maxlentgh="255" >
    
                <label for="email">Adresse email</label>
                <input type="email" class="" id="email" name="email" required>
    
                <label for="message">Message</label>
                <textarea class="" id="message" name="message" minlength="10" maxlentgh="3000"  required></textarea>
            </div>
    
            <button type="submit" class="">Envoyer</button>
        </form>
    </div>
</div>
<?php require_once 'footer.php'; ?>