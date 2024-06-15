<?php
// Define CSS classes for HTML elements
$labelClass = "mb-1 font-semibold";
$inputClass = "rounded-md mb-4 text-gray-700 py-1 px-2  focus:outline-none focus:ring focus:ring-orange-500";
$inputErrorClass = "ring ring-red-500";
$buttonClass = "bg-orange-600 rounded-md flex justify-center border-white border font-bold shadow-sm mt-6 py-1 px-4 mx-auto text-white hover:bg-orange-500 hover:shadow-md hover:shadow-orange-500 transition-all duration-300 ease-in-out";
$editButtonClass = "edit-button  hover:text-orange-700 font-bold rounded";

// Main HTML structure
?>
<main class="relative h-screen">
  <section class="absolute top-0 w-screen">
    <!-- Display error or success messages -->
    <?php if (isset($errors['post'])) { ?>
      <p class="text-white font-bold text-center p-2 bg-red-400 header-info transition-all duration-500 opacity-100"><?= $errors['post'] ?></p>
    <?php } ?>
    <?php if (isset($success['post'])) { ?>
      <p class="text-white font-bold text-center p-2 bg-green-400  header-info transition-all duration-500 opacity-100"><?= $success['post'] ?></p>
    <?php } ?>
  </section>
  <div class="content">
    <!-- Post list -->
    <div class="flex flex-col items-center ">
      <h2 class="text-4xl text-center mb-6">Liste des posts</h2>
      <div class="max-w-2xl mx-auto w-full">
        <!-- Form to send new post -->
        <form action="" method="post" class="flex flex-col mb-6 border bg-slate-950 p-6 rounded-md shadow-md shadow-slate-500">

          <!-- CSRF token and hidden fields -->
          <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">

          <!-- Post title input -->
          <label for="title" class="<?= $labelClass ?>">Titre</label>
          <input class="<?= $inputClass ?> <?= isset($errors['title']) ? $inputErrorClass : '' ?>" type="text" name="title" id="title" value="<?= $args['valeursEchappees']['title'] ?? '' ?>">
          <?php if (!empty($errors["title"])) { ?>
            <div class="text-red-500"><?= $errors["title"] ?></div>
          <?php } ?>

          <!-- Post content input -->
          <label for="content" class="<?= $labelClass ?>">Post</label>
          <textarea class="<?= $inputClass ?> <?= isset($errors['content']) ? $inputErrorClass : '' ?>" type="text" name="content" id="content"><?= $args['valeursEchappees']['content'] ?? '' ?></textarea>
          <?php if (!empty($errors["content"])) { ?>
            <div class="text-red-500"><?= $errors["content"] ?></div>
          <?php } ?>

          <button type="submit" class="<?= $buttonClass ?>"><span>Créer un post</span></button>
        </form>
        <!-- Display message if no posts -->
        <?php if (empty($posts)) { ?>
          <p class="text-gray-500 text-center">Aucun post disponible</p>
        <?php } ?>

        <!-- Display post list -->
        <?php foreach ($posts as $post) { ?>
          <div id="<?= "post-" . $post->useID ?>" class="border bg-slate-950 py-2 px-6 rounded-md shadow-md shadow-slate-500 mb-4">
            <!-- Post title and delete button -->
            <div class="flex justify-between items-center">
              <h3 class="text-2xl pb-4"><?= $post->postTitle ?></h3>
              <div class="flex gap-6">
                <?php if (isset($_SESSION['user']['id']) && $post->useID === $_SESSION['user']['id']) { ?>
                  <!-- Edit button -->
                  <button id="<?= "edit-content-post-" . $post->useID ?>" class="<?= $editButtonClass ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                  <!-- Delete form -->
                  <form action="/post/delete" method="post">
                    <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">
                    <input type="hidden" name="postID" value="<?= $post->postID ?>">
                    <button type="submit" class="text-red-500">Supprimer</button>
                  </form>
                <?php } ?>
              </div>
            </div>
            <!-- Post content and edit form -->
            <p id="<?= "content-post-" . $post->useID ?>" class="text-gray-200 p-2 mb-2 rounded-md bg-slate-800"><?= $post->postContent ?></p>
            <!-- Edit form -->
            <form action="/post/edit" method="post" id="<?= "input-content-post-" . $post->useID ?>" class="hidden edit-input relative ">
              <div class="flex items-center">
                <input type="hidden" name="tokenCSRF" value="<?= $_SESSION['tokenCSRF'] ?>">
                <input class="w-full rounded-md mb-2 p-2  focus:outline-none focus:ring focus:ring-orange-500 text-gray-950 <?= isset($errors['content']) ? $inputErrorClass : '' ?>" type="text" name="content" placeholder="<?= $post->postContent ?>" value="<?= isset($errors['content']) ? $valeursEchappees['content'] : $post->postContent ?>">
                <button type="submit" class="hover:text-green-700 font-bold rounded absolute right-0 text-green-500 text-lg mr-2"><i class="fa-solid fa-check"></i></button>
              </div>
            </form>
            <!-- Post author and creation date -->
            <div class="flex gap-6">
              <p class="text-gray-500"><?= $post->usePseudo ?></p>
              <p class="text-gray-500"> le <?= $post->createdAt ?></p>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</main>

<!-- JavaScript code -->
<script>
  // Get the header info element
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

  // Get all edit buttons
  const editButtons = document.querySelectorAll('.edit-button');
  editButtons.forEach(editButton => {
    // Add event listener to edit button click
    editButton.addEventListener('click', (e) => {
      e.preventDefault();
      const id = e.target.parentElement.id.replace('edit-content-post-', '');
      const content = document.getElementById(`content-post-${id}`);
      const input = document.getElementById(`input-content-post-${id}`);
      if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        input.classList.add('hidden');
      } else {
        content.classList.add('hidden');
        input.classList.remove('hidden');
      }
    });
  });
</script>