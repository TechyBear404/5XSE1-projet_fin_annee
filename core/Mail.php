<?php

function sendMail($to, $subject, $message, $headers = null): bool
{
  $sender = 'Info <info@gmail.com>';
  if ($headers === null) {
    $headers = [
      "From" => $sender,
      "MIME-Version" => "1.0",
      "Content-Type" => "text/html; charset=\"UTF-8\"",
      "Content-Transfer-Encoding" => "quoted-printable"
    ];
  }
  return mail($to, $subject, $message, $headers);
}

function sendVerificationMail($to, $token): bool
{
  $sender = 'Account Verification <ector.seb@gmail.com>';
  $subject = 'Account Verification';
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $url = "https://";
  } else {
    $url = "http://";
  }
  $url .= $_SERVER['HTTP_HOST'];
  $activationLink = $url . '/verify/' . $to . '/' . $token;

  $message = "<html><body>";
  $message .= '<h1>Verification de votre compte</h1>';
  $message .= "<p>Bonjour $to</p>";
  $message .= '<p>cliquez sur le lien suivant pour activer votre compte: <a href="' . $activationLink . '">Activer mon compte</a></p>';
  $message .= "</body></html>";
  $headers = [
    "From" => $sender,
    "MIME-Version" => "1.0",
    "Content-Type" => "text/html; charset=\"UTF-8\"",
    "Content-Transfer-Encoding" => "quoted-printable"
  ];
  // return sendMail($to, $subject, $message, implode("\r\n", $headers));
  return sendMail($to, $subject, $message, $headers);
}
