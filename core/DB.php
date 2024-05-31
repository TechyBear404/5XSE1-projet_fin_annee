<?php

function db(): ?PDO
{
  try {
    // use getenv() to get the environment variables
    $db = new PDO("mysql:host=" . getenv("DBHOST") . ";dbname=" . getenv("DBNAME") . ";charset=utf8", getenv("DBUSER"), getenv("DBPASSWORD"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  } catch (PDOException $e) {
    // echo 'Erreur : ' . $e->getMessage();
    return null;
  }
}

function executeQuery(string $sql, ?array $params = null)
{
  // echo "<pre> print_r($sql)</pre>";
  $db = db();
  try {
    if ($params) {
      $query = $db->prepare($sql);
      foreach ($params as $key => $value) {
        $query->bindValue($key, $value);
      }
      $query->execute();
      return $query;
    } else {
      return $db->query($sql);
    }
  } catch (PDOException $e) {
    // echo 'Erreur : ' . $e->getMessage();
    return $e->getMessage();
  }
}
