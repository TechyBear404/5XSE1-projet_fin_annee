<?php
// Include required files
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'postModel.php';

/**
 * Returns page information as an array
 */
function getPageInfos(): array
{
    return [
        'vue' => 'accueil',
        'title' => "Page d'Accueil",
        'description' => "Description de la page d'accueil...",
        'baseUrlPage' => BASE_URL . '/'
    ];
}

/**
 * Index function to display the index page
 */
function index(?array $args = []): void
{
    // Get all posts
    $args['posts'] = getPosts();

    // Show the view with the given arguments
    showView(getPageInfos(), 'index', $args);
}

/**
 * Create a new post
 */
function newPost(): void
{
    if (!isset($_SESSION['user'])) {
        $args = [];
        $args["errors"]["post"] = "Vous devez être connecté pour créer un post.";
        index($args);
        exit();
    }

    if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
        $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
        index($args);
        exit();
    } else {
        unset($_POST["tokenCSRF"]);
    }

    $formRules = getNewPostRules();

    // Validate form input
    [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
    $args["errors"] = $errors;
    $args["valeursEchappees"] = $valeursEchappees;

    if (empty($errors)) {
        // Create a new post

        try {
            createPost($args["valeursEchappees"]['newTitle'], $args["valeursEchappees"]['newContent']);
            $args = [];
            $args["success"]["post"] = "Le post a été créé avec succès.";
        } catch (Exception $e) {
            $args = [];
            $args["errors"]["post"] = "Une erreur s'est produite lors de la création du post.";
        }
    }
    index($args);
}

/**
 * Delete a post
 */
function deletePost(): void
{
    if (!isset($_SESSION['user'])) {
        $args = [];
        $args["errors"]["post"] = "Vous devez être connecté pour suprimer un post.";
        index($args);
        exit();
    }

    if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
        $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
        index($args);
        exit();
    } else {
        unset($_POST["tokenCSRF"]);
    }

    // Delete the post
    $post = removePost($_POST["postID"]);

    if (isset($post["error"])) {
        $args["errors"]["post"] = "Une erreur s'est produite lors de la suppression du post.";
    } else {
        $args["success"]["post"] = "Le post a été supprimé avec succès.";
    }

    index($args);
}

/**
 * Edit a post
 */
function editPost(): void
{
    if (!isset($_SESSION['user'])) {
        $args = [];
        $args["errors"]["post"] = "Vous devez être connecté pour créer un post.";
        index($args);
        exit();
    }

    if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
        $args["errors"]["post"] = "Une erreur s'est produite lors de la soumission du formulaire.";
        index($args);
        exit();
    } else {
        unset($_POST["tokenCSRF"]);
    }

    $formRules = getEditPostRules();

    // Validate form input
    [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
    $args["errors"] = $errors;
    $args["valeursEchappees"] = $valeursEchappees;

    if (empty($errors)) {
        // Edit the post
        $post = editPostContent($_POST['postID'], $args["valeursEchappees"]['editContent']);

        if (isset($post["error"])) {
            $args["errors"]["post"] = "Une erreur s'est produite lors de la modification du post.";
        } elseif (isset($post["success"])) {
            $args["success"]["post"] = "Le post a été modifié avec succès.";
        }
    }
    index($args);
}
