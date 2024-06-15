<?php
// Include the navigation file
require_once __DIR__ . DS . 'nav.php';

// Create navigation items
$nav = createNavItems();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Set page title and description using $pageInfos array -->
    <meta name="description" content="<?= $pageInfos['description'] ?? ''  ?>">
    <title><?= $pageInfos['title'] ?? '' ?></title>

    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="min-w-[400px] h-screen">
    <!-- Header section with navigation -->
    <header class="sticky top-0 w-full bg-slate-950 z-50">
        <nav class="w-full py-2">
            <ul class="md:flex gap-6 justify-center items-center font-bold uppercase text-center">
                <!-- Display navigation items -->
                <?= $nav ?>
            </ul>
        </nav>
    </header>