<?php
function createNavItem(string $segmentUrl, string $pageName): string
{
  $currentPage = $_SERVER['REQUEST_URI'] === $segmentUrl;
  $classCss = $currentPage ? 'active' : '';
  ob_start();
?>
  <li><a class="<?= $classCss ?>" href="<?= $segmentUrl ?>"><?= $pageName ?></a></li>
<?php
  return ob_get_clean();
}

function createNavItems(): string
{
  return createNavItem(BASE_URL . '/', 'Accueil') .
    createNavItem(BASE_URL . '/login', 'Connection') .
    createNavItem(BASE_URL . '/register', 'Inscription') .
    createNavItem(BASE_URL . '/contact', 'Contact');
}
?>


<!-- BASE_URL . "/index.php" => 'Accueil',
BASE_URL . "/contact.php" => 'Contact',
BASE_URL . "/auth/login.php" => 'Login',
BASE_URL . "/auth/register.php" => 'Register', -->