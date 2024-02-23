<?php
define('BASE_URL', "/5xse1/projet_fin_annee");

function classSuivantLeChemin()
{
    $pages = [
        BASE_URL . "/index.php" => 'Accueil',
        BASE_URL . "/contact.php" => 'Contact',
    ];
    foreach ($pages as $page => $label) {
        $class = ($_SERVER['REQUEST_URI'] == $page) ? 'active' : '';
        echo '<li><a href="' . $page . '" class="' . $class . '">' . $label . '</a></li>';
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= $metaDescription ?>">
    <title><?= $pageTitre ?></title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <header class="">
        <nav>
            <ul>
                <?= classSuivantLeChemin() ?>
            </ul>
        </nav>
    </header>
    <main>