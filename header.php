<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?=$metaDescription?>">
    <title><?=$pageTitre?></title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <header class="">
        <nav>
            <ul>
                <li >
                    <a href="./index.php" class="<?= (end(explode('/', $_SERVER["SCRIPT_NAME"])) == "index.php") ? "active" : ""?>">Accueil</a>
                </li>
                <li>
                    <a href="./contact.php" class="<?= (end(explode('/', $_SERVER["SCRIPT_NAME"])) == "contact.php") ? "active" : ""?>">Contact</a>
                </li>
            </ul>
        </nav>
    </header>
    <main>