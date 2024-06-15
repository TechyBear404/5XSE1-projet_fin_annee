<?php

// Initialize the session cookie settings
$lifeTime = 7 * 24 * 60 * 60; // 7 days

// Set PHP session configuration
ini_set('session.use_strict_mode', 1); // enable strict mode for session
ini_set('session.use_only_cookies', 1); // force sessions to only use cookies
session_set_cookie_params([
  // 'lifetime' => $lifeTime, // uncomment to set the lifetime of the session cookie
  'path' => '/', // available in entire domain
  'secure' => false, // set to true if using HTTPS
  'httponly' => true, // prevent JavaScript access to the cookie
  'samesite' => 'lax' // set same-site policy to lax
]);
session_start(); // start the session

// Function to generate a token for CSRF protection
function generateCSRF(): string
{
  if (empty($_SESSION['tokenCSRF'])) {
    $_SESSION['tokenCSRF'] = bin2hex(random_bytes(32)); // generate a random token and store in session
  }
  return $_SESSION['tokenCSRF'];
}
generateCSRF(); // generate the CSRF token

// Function to check the CSRF token
function checkCSRF($formToken): bool
{
  if (isset($formToken) && isset($_SESSION['tokenCSRF']) && $formToken === $_SESSION['tokenCSRF']) {
    // if the form token matches the session token, return true
    return true;
  }
  return false; // otherwise, return false
}
