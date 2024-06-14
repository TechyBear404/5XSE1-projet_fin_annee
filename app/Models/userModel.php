<?php
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'DB.php';


function getLoginRules()
{
  return [
    "rules" => [
      'pseudo' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
      ],
      'password' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 72,
        'type' => 'password',
      ]
    ],
    'inputNames' => [
      'pseudo' => 'Pseudo',
      'password' => 'Mot de passe'
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
      'email' => "Le champ %0% doit contenir adresse email valide.",
      'passwordConfirm' => 'Les mots de passe ne correspondent pas.',
      'unique' => "Le champ %0% est déjà utilisé."
    ]
  ];
}

function getRegisterRules()
{
  return [
    "rules" => [
      'pseudo' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
        'unique' => 'user'
      ],
      'email' => [
        'required' => true,
        'type' => 'email',
        'unique' => 'email'
      ],
      'password' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 72,
        'type' => 'password',
      ],
      'passwordConfirm' => [
        'required' => true,
        'type' => 'passwordConfirm',
      ]
    ],
    'inputNames' => [
      'pseudo' => 'Pseudo',
      'email' => 'Adresse email',
      'password' => 'Mot de passe',
      'passwordConfirm' => 'Confirmation du mot de passe'
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
      'email' => "Le champ %0% doit contenir adresse email valide.",
      'passwordConfirm' => 'Les mots de passe ne correspondent pas.',
      'unique' => "Le champ %0% est déjà utilisé."
    ]
  ];
}

function getEditProfileRules()
{
  return [
    "rules" => [
      'pseudo' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
        'unique' => 'user'
      ],
      'email' => [
        'required' => true,
        'type' => 'email',
        'unique' => 'email'
      ],
      'passwordNew' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 72,
        'type' => 'passwordNew',
      ],
      'passwordConfirm' => [
        'required' => true,
        'type' => 'passwordConfirm',
      ],
      'passwordCurrent' => [
        'required' => true,
        'type' => 'passwordCurrent',
      ]
    ],
    'inputNames' => [
      'pseudo' => 'Pseudo',
      'email' => 'Adresse email',
      'passwordNew' => 'Nouveau mot de passe',
      'passwordConfirm' => 'Confirmation du mot de passe',
      'passwordCurrent' => 'Mot de passe actuel'
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
      'email' => "Le champ %0% doit contenir adresse email valide.",
      'passwordConfirm' => 'Les mots de passe ne correspondent pas.',
      'passwordCurrent' => 'Votre mot de passe actuel est incorrect.',
      'unique' => "Le champ %0% est déjà utilisé."
    ]
  ];
}



function getTable()
{
  return 'users';
}

function createNewUser($pseudo, $email, $password, $activationToken)
{
  $table = getTable();
  $sql = "INSERT INTO $table (usePseudo, useEmail, usePassword, useActivationToken) VALUES (:pseudo, :email, :password, :activationToken)";
  $pwd = password_hash($password, PASSWORD_DEFAULT);

  return executeQuery($sql, [':pseudo' => $pseudo, ':email' => $email, ':password' => $pwd, ':activationToken' => $activationToken]);
}

//function to validate accont by clicking link in email
function activateUser($id)
{
  $table = getTable();
  $sql = "UPDATE $table SET useActivated = 1 WHERE useID = :id";
  return executeQuery($sql, [':id' => $id]);
}

function getUsers()
{
  $table = getTable();
  $sql = "SELECT * FROM $table";
  return executeQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getUserByID($id)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE useID = :id";
  return executeQuery($sql, [':id' => $id])->fetch(PDO::FETCH_ASSOC);
}

function getUserByPseudo($pseudo)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE usePseudo = :pseudo";
  return executeQuery($sql, [':pseudo' => $pseudo])->fetch(PDO::FETCH_ASSOC);
}

function isPseudoUsed($pseudo)
{
  $user = getUserByPseudo($pseudo);
  if ($user) {
    return true;
  } else {
    return false;
  }
}

function getUserByEmail($email)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE useEmail = :email";
  return executeQuery($sql, [':email' => $email])->fetch(PDO::FETCH_ASSOC);
}

function isEmailUsed($email)
{
  $user = getUserByEmail($email);
  if ($user) {
    return true;
  } else {
    return false;
  }
}

function updateUser(int $id, ?string $pseudo = null, ?string $email = null, ?string $password = null)
{
  $table = getTable();
  $fields = "";
  $fieldsValues = ['id' => $id];
  if ($pseudo) {
    if ($fields !== "") {
      $fields .= ", ";
    }
    $fields .= "usePseudo = :pseudo";
    $fieldsValues[':pseudo'] = $pseudo;
  }
  if ($email) {
    if ($fields !== "") {
      $fields .= ", ";
    }
    $fields .= "useEmail = :email";
    $fieldsValues[':email'] = $email;
  }
  if ($password) {
    if ($fields !== "") {
      $fields .= ", ";
    }
    $fields .= "usePassword = :password";
    $fieldsValues[':password'] = password_hash($password, PASSWORD_DEFAULT);
  }
  $sql = "UPDATE $table SET $fields WHERE useID = :id";

  return executeQuery($sql, $fieldsValues);
}

function deleteUser(int $id)
{
  $table = getTable();
  $sql = "DELETE FROM $table WHERE useID = :id";
  return executeQuery($sql, [':id' => $id]);
}

function connectUser($pseudo, $password)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE usePseudo = :pseudo";
  $user = executeQuery($sql, [':pseudo' => $pseudo])->fetch(PDO::FETCH_ASSOC);

  if (empty($user)) {
    return ['error' => ['pseudo' => 'Pseudo incorrect']];
  } else if (!password_verify($password, $user['usePassword'])) {
    return ['error' => ['password' => 'Mot de passe incorrect']];
  } else if ($user['useActivated'] == 0) {
    return ['error' => ['activation' => 'Compte non activé']];
  } elseif (!empty($user) && password_verify($password, $user['usePassword']) && $user['useActivated'] == 1) {
    $_SESSION['user']['id'] = $user['useID'];
    return ['success' => 'Connexion réussie'];
  }
}

function disconnectUser()
{
  session_destroy();
}

function isConnected()
{
  if (!isset($_SESSION['user']['id'])) {
    return false;
  } else {
    return true;
  }
}

function isUserPassword($password)
{
  $table = getTable();
  $id = $_SESSION['user']['id'];
  $sql = "SELECT usePassword FROM $table WHERE useID = :id";
  $user = executeQuery($sql, [':id' => $id])->fetch(PDO::FETCH_ASSOC);

  if (!empty($user) && password_verify($password, $user['usePassword'])) {
    return true;
  } else {
    return false;
  }
}
