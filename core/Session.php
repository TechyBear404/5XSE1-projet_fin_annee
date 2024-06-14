<?php

// init session cookie
$lifeTime = 7 * 24 * 60 * 60;

ini_set('session.use_strict_mode', 1);
ini_set('session.use_only_cookies', 1);
session_set_cookie_params([
  // 'lifetime' => $lifeTime,
  'path' => '/',
  'secure' => false,
  'httponly' => true,
  'samesite' => 'lax'
]);
session_start();

// generate a token for CSRF
function generateCSRF(): string
{
  if (empty($_SESSION['tokenCSRF'])) {
    $_SESSION['tokenCSRF'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['tokenCSRF'];
}
$tokenCSRF = generateCSRF();


function checkCSRF($formToken): bool
{
  if (isset($formToken) && isset($_SESSION['tokenCSRF']) && $formToken === $_SESSION['tokenCSRF']) {
    return true;
  }
  return false;
}
