<?php

function createNavItems()
{
  $pages = [
    ["url" => BASE_URL . '/', "name" => 'Accueil'],
    ["url" => BASE_URL . '/contact', "name" => 'Contact'],
    ["url" => BASE_URL . '/register', "name" => 'Enregistrement', "auth" => false],
    ["url" => BASE_URL . '/login', "name" => 'Connexion', "auth" => false],
    ["url" => BASE_URL . '/logout', "name" => 'Déconnexion', "auth" => true],
    ["url" => BASE_URL . '/profile', "name" => 'Profile', "auth" => true],
  ];

  $navlist = '';
  foreach ($pages as $page) {
    $classCss = $_SERVER['REQUEST_URI'] === $page['url'] ? 'scale-125 underline' : '';
    if (isset($page['auth'])) {
      if ($page['auth'] === true && isset($_SESSION['user'])) {
        $navlist .= "<li class='nav-item'><a href='{$page['url']}' class='$classCss'>{$page['name']}</a></li>";
      } elseif ($page['auth'] === false && !isset($_SESSION['user'])) {
        $navlist .= "<li class='nav-item'><a href='{$page['url']}' class='$classCss'>{$page['name']}</a></li>";
      }
    } else {
      $navlist .= "<li class='nav-item'><a href='{$page['url']}' class='$classCss'>{$page['name']}</a></li>";
    }
  }
  return $navlist;
}
