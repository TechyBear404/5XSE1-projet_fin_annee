<?php
// Define CSS classes for form elements
$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-gray-700 py-1 px-2  focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-orange-600 rounded-md flex justify-center border-white border font-bold shadow-sm mt-6 py-1 px-4 mx-auto text-white hover:bg-orange-500 hover:shadow-md hover:shadow-orange-500 transition-all duration-300 ease-in-out";
?>

<!-- Main container -->
<main class="relative  min-h-screen">
    <!-- Section for displaying error or success messages -->
    <section class="absolute top-0 w-full">
        <?php if (isset($errors['contact'])) { ?>
            <!-- Display error message if activation error occurs -->
            <p class="text-white font-bold text-center p-2 bg-red-400 header-info transition-all duration-500 opacity-100"><?= $errors['contact'] ?></p>
        <?php } ?>
        <?php if (isset($success['contact'])) { ?>
            <!-- Display success message if activation is successful -->
            <p class="text-white font-bold text-center p-2 bg-green-400 header-info transition-all duration-500 opacity-100"><?= $success['contact'] ?></p>
        <?php } ?>
    </section>
    <div class="content">
        <!-- Contact section -->
        <div id="contact" class="flex flex-col items-center">
            <h2 class="text-4xl text-center mb-6">Contact</h2>
            <!-- Form container -->
            <div class="max-w-2xl mx-auto w-full border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">
                <!-- Form with POST method -->
                <form id="contact-form" method="POST" class="flex flex-col">
                    <!-- Hidden input for CSRF token -->
                    <input type="hidden" name="tokenCSRF" value="<?php echo $_SESSION['tokenCSRF'] ?>">

                    <!-- First name input -->
                    <label class="<?= $labelClass ?>" for="firstName">Prénom</label>
                    <input class="<?= $inputClass ?> <?= isset($errors['firstName']) ? $inputErrorClass : '' ?>" type="text" name="firstName" id="pseudo" value="<?= $args['valeursEchappees']['firstName'] ?? '' ?>" min="2" max="255" required>
                    <?php if (!empty($errors["firstName"])) { ?>
                        <!-- Error message for first name -->
                        <div class="text-red-500"><?= $errors["firstName"] ?></div>
                    <?php } ?>

                    <!-- Last name input -->
                    <label class="<?= $labelClass ?>" for="lastName">Nom</label>
                    <input class="<?= $inputClass ?> <?= isset($errors['lastName']) ? $inputErrorClass : '' ?>" type="text" name="lastName" id="lastName" value="<?= $args['valeursEchappees']['lastName'] ?? '' ?>" min="2" max="255" required>
                    <?php if (!empty($errors["lastName"])) { ?>
                        <!-- Error message for last name -->
                        <div class="text-red-500"><?= $errors["lastName"] ?></div>
                    <?php } ?>

                    <!-- Email input -->
                    <label class="<?= $labelClass ?>" for="email">Adresse email</label>
                    <input class="<?= $inputClass ?> <?= isset($errors['email']) ? $inputErrorClass : '' ?>" type="email" name="email" id="email" value="<?= $args['valeursEchappees']['email'] ?? '' ?>" required>
                    <?php if (!empty($errors["email"])) { ?>
                        <!-- Error message for email -->
                        <div class="text-red-500"><?= $errors["email"] ?></div>
                    <?php } ?>

                    <!-- Message textarea -->
                    <label class="<?= $labelClass ?>" for="message">Message</label>
                    <textarea class="<?= $inputClass ?> <?= isset($errors['message']) ? $inputErrorClass : '' ?>" name="message" id="message" cols="30" rows="10" min="8" max="500" required><?= $args['valeursEchappees']['message'] ?? '' ?></textarea>
                    <?php if (!empty($errors["message"])) { ?>
                        <!-- Error message for message -->
                        <div class="text-red-500"><?= $errors["message"] ?></div>
                    <?php } ?>


                    <!-- Submit button -->
                    <button type="submit" class="<?= $buttonClass ?>"><span>Envoyer</span></button>
                </form>
            </div>
        </div>
    </div>
</main>