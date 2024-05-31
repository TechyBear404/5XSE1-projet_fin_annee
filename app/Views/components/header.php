<?php
require_once __DIR__ . DS . 'nav.php';
$nav = createNavItems();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $pageInfos['description'] ?? ''  ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <title><?= $pageInfos['title'] ?? '' ?></title>
</head>

<body class="mt-14">
    <header class="h-12 fixed top-0 w-full bg-slate-950">
        <nav class="w-full h-full">
            <ul class="flex gap-6 justify-center items-center h-full font-bold uppercase">
                <?= $nav ?>
            </ul>
        </nav>
    </header>
    <main class="mt-10">