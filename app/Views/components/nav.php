<?php

function createNavItems()
{
  // Define an array of pages, each with a URL and name
  $pages = [
    ["url" => BASE_URL . '/', "name" => 'Accueil'],
    ["url" => BASE_URL . '/contact', "name" => 'Contact'],
    ["url" => BASE_URL . '/register', "name" => 'Enregistrement', "auth" => false],
    ["url" => BASE_URL . '/login', "name" => 'Connexion', "auth" => false],
    ["url" => BASE_URL . '/logout', "name" => 'Déconnexion', "auth" => true],
    ["url" => BASE_URL . '/profile', "name" => 'Profil', "auth" => true],
  ];

  // Define the CSS classes for the navigation items
  $navClass = 'uppercase text-lg font-bold text-white hover:text-orange-500 transition-all duration-300 ease-in-out';

  // Initialize an empty string to store the navigation list
  $navlist = '';

  // Loop through each page and generate the navigation item
  foreach ($pages as $page) {
    // Determine if the current page is active
    $currentPageCss = $_SERVER['REQUEST_URI'] === $page['url'] ? 'scale-125 underline active' : '';

    // Check if the page has authentication requirements
    if (isset($page['auth'])) {
      // If the page requires authentication and the user is logged in, display the link
      if ($page['auth'] === true && isset($_SESSION['user'])) {
        $navlist .= "<li class='$navClass'><a href='{$page['url']}' class='$currentPageCss'>{$page['name']}</a></li>";
      }
      // If the page does not require authentication and the user is not logged in, display the link
      elseif ($page['auth'] === false && !isset($_SESSION['user'])) {
        $navlist .= "<li class='$navClass'><a href='{$page['url']}' class='$currentPageCss'>{$page['name']}</a></li>";
      }
    } else {
      // If there are no authentication requirements, display the link
      $navlist .= "<li class='$navClass'><a href='{$page['url']}' class='$currentPageCss'>{$page['name']}</a></li>";
    }
  }

  // Return the generated navigation list
  return $navlist;
}
