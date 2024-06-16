<?php
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'DB.php';
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'Mail.php';


function getLoginRules()
{
  return [
    "rules" => [
      'email' => [
        'required' => true,
        'type' => 'email',
      ],
      'password' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 32,
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
        'maxLength' => 16,
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
        'maxLength' => 32,
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
      'passwordCurrent' => [
        'required' => true,
        'type' => 'passwordCurrent',
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



// Returns the table name, in this case 'users'
function getTable()
{
  return 'users';
}

// Creates a new user with the provided pseudo, email, password, and activation token
function createNewUser($pseudo, $email, $password, $activationToken)
{
  $table = getTable();
  $sql = "INSERT INTO $table (usePseudo, useEmail, usePassword, useActivationToken) VALUES (:pseudo, :email, :password, :activationToken)";
  $pwd = password_hash($password, PASSWORD_DEFAULT);

  // Use prepared statement to prevent SQL injection
  return executeQuery($sql, [':pseudo' => $pseudo, ':email' => $email, ':password' => $pwd, ':activationToken' => $activationToken]);
}

// Activates a user by updating the useActivated field to 1
function activateUser($id)
{
  $table = getTable();
  $sql = "UPDATE $table SET useActivated = 1 WHERE useID = :id";
  return executeQuery($sql, [':id' => $id]);
}

// Retrieves all users
function getUsers()
{
  $table = getTable();
  $sql = "SELECT * FROM $table";
  return executeQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// Retrieves a user by ID
function getUserByID($id)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE useID = :id";
  return executeQuery($sql, [':id' => $id])->fetch(PDO::FETCH_ASSOC);
}

// Retrieves a user by pseudo
function getUserByPseudo($pseudo)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE usePseudo = :pseudo";
  return executeQuery($sql, [':pseudo' => $pseudo])->fetch(PDO::FETCH_ASSOC);
}

// Checks if a pseudo is already used
function isPseudoUsed($pseudo)
{
  $user = getUserByPseudo($pseudo);
  return !empty($user);
}

// Retrieves a user by email
function getUserByEmail($email)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE useEmail = :email";
  return executeQuery($sql, [':email' => $email])->fetch(PDO::FETCH_ASSOC);
}

// Checks if an email is already used
function isEmailUsed($email)
{
  $user = getUserByEmail($email);
  return !empty($user);
}

// Updates a user's information
function updateUser($user)
{
  $table = getTable();
  $fields = "";
  $fieldsValues = ['id' => $user['id']];

  if (isset($user['pseudo'])) {
    if (!empty($fields)) {
      $fields .= ", ";
    }
    $fields .= "usePseudo = :pseudo";
    $fieldsValues[':pseudo'] = $user['pseudo'];
  }

  if (isset($user['email'])) {
    if (!empty($fields)) {
      $fields .= ", ";
    }
    $fields .= "useEmail = :email";
    $fieldsValues[':email'] = $user['email'];
  }

  if (isset($user['password'])) {
    if (!empty($fields)) {
      $fields .= ", ";
    }
    $fields .= "usePassword = :password";
    $fieldsValues[':password'] = password_hash($user['password'], PASSWORD_DEFAULT);
  }

  $sql = "UPDATE $table SET $fields WHERE useID = :id";

  return executeQuery($sql, $fieldsValues);
}

// Deletes a user by ID
function deleteUser($id)
{
  $table = getTable();
  $sql = "DELETE FROM $table WHERE useID = :id";
  return executeQuery($sql, [':id' => $id]);
}

// Connects a user by email and password
function connectUser($email, $password)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE useEmail = :email";
  $user = executeQuery($sql, [':email' => $email])->fetch(PDO::FETCH_ASSOC);

  if (empty($user)) {
    return ['error' => ['email' => 'Email incorrect']];
  } elseif (!password_verify($password, $user['usePassword'])) {
    return ['error' => ['password' => 'Mot de passe incorrect']];
  } elseif ($user['useActivated'] == 0) {
    return ['error' => ['activation' => 'Compte non activé, veuillez vérifier votre boîte mail']];
  } else {
    $_SESSION['user']['id'] = $user['useID'];
    return ['success' => 'Connexion réussie'];
  }
}

// Disconnects a user
function disconnectUser()
{
  session_destroy();
}

// Checks if a user is connected
function isConnected()
{
  return isset($_SESSION['user']['id']);
}

// Checks if a password is correct for the current user
function isUserPassword($password)
{
  $table = getTable();
  $id = $_SESSION['user']['id'];
  $sql = "SELECT usePassword FROM $table WHERE useID = :id";
  $user = executeQuery($sql, [':id' => $id])->fetch(PDO::FETCH_ASSOC);

  return password_verify($password, $user['usePassword']);
}

// Reactivates a user by updating their activation token
function reActivateUser($pseudo, $validationToken)
{
  $table = getTable();
  $sql = "UPDATE $table SET useActivationToken = :activationToken WHERE usePseudo = :pseudo";
  return executeQuery($sql, [':activationToken' => $validationToken, ':pseudo' => $pseudo]);
}
