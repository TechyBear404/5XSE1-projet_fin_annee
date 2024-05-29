<?php
require_once dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'DB.php';

function getRules()
{
  return [
    "rules" => [
      'pseudo' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 255,
        'unique' => 'users'
      ],
      'email' => [
        'required' => true,
        'type' => 'email',
        'unique' => 'users'
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

function getTable()
{
  return 'users';
}

function createNewUser($pseudo, $email, $password)
{
  $table = getTable();
  $sql = "INSERT INTO $table (usePseudo, useEmail, usePassword) VALUES (:pseudo, :email, :password)";
  $pwd = password_hash($password, PASSWORD_DEFAULT);

  return executeQuery($sql, [':pseudo' => $pseudo, ':email' => $email, ':password' => $pwd]);
}

function getUsers()
{
  $table = getTable();
  $sql = "SELECT * FROM $table";
  return executeQuery($sql)->fetchAll(PDO::FETCH_ASSOC);
}

function getUser($id)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE useID = :id";
  return executeQuery($sql, [':id' => $id])->fetch(PDO::FETCH_ASSOC);
}

function updateUser(int $id, string $pseudo, string $email, ?string $password = null)
{
  $table = getTable();

  if ($password) {
    $sql = "UPDATE $table SET usePseudo = :pseudo, useEmail = :email, usePassword = :password WHERE useID = :id";
    $pwd = password_hash($password, PASSWORD_DEFAULT);
  } else {
    $sql = "UPDATE $table SET usePseudo = :pseudo, useEmail = :email WHERE useID = :id";
  }

  return executeQuery($sql, [':id' => $id, ':pseudo' => $pseudo, ':email' => $email, ':password' => $pwd]);
}

function deleteUser(int $id)
{
  $db = db();
  $table = getTable();
  $sql = "DELETE FROM $table WHERE useID = :id";
  return executeQuery($sql, [':id' => $id]);
}
