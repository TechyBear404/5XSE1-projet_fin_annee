<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'nav.php';
$nav = createNavItems();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?>">
    <title><?= $pageTitle ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/style.css">
</head>

<body>
    <header class="">
        <nav>
            <ul>
                <?= $nav ?>
            </ul>
        </nav>
    </header>
    <main>