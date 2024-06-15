<?php

/**
 * Sends an email using the PHP mail function
 *
 * @param string $to      The recipient's email address
 * @param string $subject The email subject
 * @param string $message The email message
 * @param array  $headers Optional email headers
 *
 * @return bool Whether the email was sent successfully
 */
function sendMail($to, $subject, $message, $headers = null): bool
{
  $sender = 'Info <techybear@techybear.eu>';

  // If no custom headers are provided, use default headers
  if ($headers === null) {
    $headers = [
      "From" => $sender,
      "MIME-Version" => "1.0",
      "Content-Type" => "text/html; charset=\"UTF-8\"",
      "Content-Transfer-Encoding" => "quoted-printable"
    ];
  }

  // Send the email using the PHP mail function
  return mail($to, $subject, $message, implode("\r\n", $headers));
}

/**
 * Sends a verification email to a user
 *
 * @param string $to    The recipient's email address
 * @param string $token The verification token
 *
 * @return bool Whether the email was sent successfully
 */
function sendVerificationMail($to, $token): bool
{
  $sender = 'Account Verification <techybear@techybear.eu>';
  $subject = 'Account Verification';

  // Determine the protocol (HTTP or HTTPS) and the host
  $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
  $host = $_SERVER['HTTP_HOST'];

  // Construct the activation link
  $activationLink = "{$protocol}://{$host}/verify/{$to}/{$token}";

  // Construct the email message
  $message = "<html><body>";
  $message .= '<h1>Verification de votre compte</h1>';
  $message .= "<p>Bonjour {$to}</p>";
  $message .= "<p>cliquez sur le lien suivant pour activer votre compte: <a href='{$activationLink}'>Activer mon compte</a></p>";
  $message .= "</body></html>";

  // Set up the email headers
  $headers = [
    "From" => $sender,
    "MIME-Version" => "1.0",
    "Content-Type" => "text/html; charset=\"UTF-8\"",
    "Content-Transfer-Encoding" => "quoted-printable"
  ];

  // Send the verification email
  return sendMail($to, $subject, $message, $headers);
}
