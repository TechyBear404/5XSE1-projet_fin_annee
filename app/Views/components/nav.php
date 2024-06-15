<?php

function createNavItems()
{
  $pages = [
    ["url" => BASE_URL . '/', "name" => 'Accueil'],
    ["url" => BASE_URL . '/contact', "name" => 'Contact'],
    ["url" => BASE_URL . '/register', "name" => 'Enregistrement', "auth" => false],
    ["url" => BASE_URL . '/login', "name" => 'Connexion', "auth" => false],
    ["url" => BASE_URL . '/logout', "name" => 'Déconnexion', "auth" => true],
    ["url" => BASE_URL . '/profile', "name" => 'Profil', "auth" => true],
  ];
  $navClass = 'uppercase text-lg font-bold text-white hover:text-orange-500 transition-all duration-300 ease-in-out';
  $navlist = '';
  foreach ($pages as $page) {
    $currentPageCss = $_SERVER['REQUEST_URI'] === $page['url'] ? 'scale-125 underline active' : '';
    if (isset($page['auth'])) {
      if ($page['auth'] === true && isset($_SESSION['user'])) {
        $navlist .= "<li class='$navClass'><a href='{$page['url']}' class='$currentPageCss'>{$page['name']}</a></li>";
      } elseif ($page['auth'] === false && !isset($_SESSION['user'])) {
        $navlist .= "<li class='$navClass'><a href='{$page['url']}' class='$currentPageCss'>{$page['name']}</a></li>";
      }
    } else {
      $navlist .= "<li class='$navClass'><a href='{$page['url']}' class='$currentPageCss'>{$page['name']}</a></li>";
    }
  }
  return $navlist;
}
