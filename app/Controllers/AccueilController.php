<?php
// Importer le gestionnaire de vues.
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'GestionVue.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'FormManager.php';
require_once dirname(__DIR__) . DS . 'Models' . DS . 'postModel.php';

// phpinfo();
// Communiquer les informations de la page nécessaire au bon fonctionnement de la vue :
function getPageInfos(): array
{
    return [
        'vue' => 'accueil',
        'title' => "Page d'Accueil",
        'description' => "Description de la page d'accueil..."
    ];
}

// index : Afficher la liste des utilisateurs (il s'agit de la partie chargée par défaut) :
function index(?array $args = []): void
{
    $args['posts'] = getPosts();
    // Afficher la vue "vue_accueil.php".
    showView(getPageInfos(), 'index', $args);
}


function newPost(): void
{
    $formRules = getNewPostRules();
    // check if the tokenCSRF is valid
    if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
        $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
        // echo "newPost";
        index($args);
        exit();
    } else {
        // remove "tokenCSRF" from the array $_POST if it's valid
        unset($_POST["tokenCSRF"]);
    }
    $args = [];
    [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
    $args["errors"] = $errors;
    $args["valeursEchappees"] = $valeursEchappees;
    // Call Vue.
    if (empty($errors)) {

        $post = createPost($args["valeursEchappees"]['title'], $args["valeursEchappees"]['content']);
        if (isset($post)) {
            $args = [];
            $args["success"]["post"] = "Le post a été créé avec succès.";
        } elseif (isset($post["error"])) {
            $args["errors"]["post"] = "Une erreur s'est produite lors de la création du post.";
        }
        index($args);
    } else {
        index($args);
    }
}

function deletePost(): void
{

    // check if the tokenCSRF is valid
    if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
        $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
        // echo "newPost";
        index($args);
        exit();
    } else {
        // remove "tokenCSRF" from the array $_POST if it's valid
        unset($_POST["tokenCSRF"]);
    }
    $args = [];
    // $args["errors"] = ["post" => "Une erreur s'est produite lors de la suppression du post."];
    $args["success"] = ["post" => "Le post a été supprimé avec succès."];
    $post = removePost($_POST["postID"]);

    if (isset($post)) {
        $args["success"]["post"] = "Le post a été supprimé avec succès.";
    } elseif (isset($post["error"])) {
        $args["errors"]["post"] = "Une erreur s'est produite lors de la suppression du post.";
    }
    // Call Vue.
    // if (empty($errors)) {

    //     $post = createPost($args["valeursEchappees"]['title'], $args["valeursEchappees"]['content']);
    //     echo '<pre>' . print_r($post, true) . '</pre>';
    //     // if (isset($post["success"])) {
    //     //     $args["newPost"]["success"] = $post["success"];
    //     // } elseif (isset($post["error"])) {
    //     //     $args["newPost"]["errors"] = $post["error"];
    //     // }
    index($args);
    // } else {
    //     index($args);
    // }
}

function editPost(): void
{
    $formRules = getNewPostRules();
    // check if the tokenCSRF is valid
    if (!isset($_POST["tokenCSRF"]) || !checkCSRF($_POST["tokenCSRF"])) {
        $args["errors"]["tokenCSRF"] = "Une erreur s'est produite lors de la soumission du formulaire.";
        // echo "newPost";
        index($args);
        exit();
    } else {
        // remove "tokenCSRF" from the array $_POST if it's valid
        unset($_POST["tokenCSRF"]);
    }
    $args = [];
    [$errors, $valeursEchappees] = verifChamps($formRules, $_POST);
    $args["errors"] = $errors;
    $args["valeursEchappees"] = $valeursEchappees;
    // Call Vue.
    if (empty($errors)) {

        $post = editPostContent($args["valeursEchappees"]['title'], $args["valeursEchappees"]['content']);
        if (isset($post)) {
            $args["success"]["post"] = "Le post a été modifié avec succès.";
        } elseif (isset($post["error"])) {
            $args["errors"]["post"] = "Une erreur s'est produite lors de la modification du post.";
        }
        index($args);
    } else {
        index($args);
    }
}
