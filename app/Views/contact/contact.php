<?php
// $pageTitre = "Contact";
// $metaDescription = "Formulaire de contact";

$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-gray-700 py-1 px-2  focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-orange-600 rounded-md flex justify-center border-white border font-bold shadow-sm mt-6 py-1 px-4 mx-auto text-white hover:bg-orange-500 hover:shadow-md hover:shadow-orange-500 transition-all duration-300 ease-in-out";;
?>

<main class="relative h-full">
    <div class="content">
        <div id="contact" class="flex flex-col items-center ">
            <h2 class="text-4xl text-center mb-6">Contact</h2>
            <div class="max-w-2xl mx-auto w-full border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">
                <form id="contact-form" method="POST" class="flex flex-col">
                    <input type="hidden" name="tokenCSRF" value="<?php echo $_SESSION['tokenCSRF'] ?>">

                    <label class="<?= $labelClass ?>" for="firstName">Prénom</label>
                    <input class="<?= $inputClass ?> <?= isset($errors['firstName']) ? $inputErrorClass : '' ?>" type="mail" name="firstName" id="pseudo" value="<?= $args['valeursEchappees']['firstName'] ?? '' ?>">
                    <?php if (!empty($errors["firstName"])) { ?>
                        <div class="text-red-500"><?= $errors["firstName"] ?></div>
                    <?php } ?>

                    <label class="<?= $labelClass ?>" for="lastName">Nom</label>
                    <input class="<?= $inputClass ?> <?= isset($errors['lastName']) ? $inputErrorClass : '' ?>" type="text" name="lastName" id="lastName" value="<?= $args['valeursEchappees']['lastName'] ?? '' ?>">
                    <?php if (!empty($errors["lastName"])) { ?>
                        <div class="text-red-500"><?= $errors["lastName"] ?></div>
                    <?php } ?>

                    <label class="<?= $labelClass ?>" for="email">Adresse email</label>
                    <input class="<?= $inputClass ?> <?= isset($errors['email']) ? $inputErrorClass : '' ?>" type="mail" name="email" id="email" value="<?= $args['valeursEchappees']['email'] ?? '' ?>">
                    <?php if (!empty($errors["email"])) { ?>
                        <div class="text-red-500"><?= $errors["email"] ?></div>
                    <?php } ?>

                    <label class="<?= $labelClass ?>" for="message">Message</label>
                    <textarea class="<?= $inputClass ?> <?= isset($errors['message']) ? $inputErrorClass : '' ?>" name="message" id="message" cols="30" rows="10"><?= $args['valeursEchappees']['message'] ?? '' ?></textarea>
                    <?php if (!empty($errors["message"])) { ?>
                        <div class="text-red-500"><?= $errors["message"] ?></div>
                    <?php } ?>


                    <button type="submit" class="<?= $buttonClass ?>"><span>Envoyer</span></button>
                </form>
            </div>
        </div>
    </div>
</main>