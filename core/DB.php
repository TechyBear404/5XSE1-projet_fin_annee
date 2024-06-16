<?php

// Establishes a connection to the database
function db(): ?PDO
{
  try {
    // Create a new PDO instance using environment variables for database connection details
    $db = new PDO("mysql:host=" . getenv("DBHOST") . ";dbname=" . getenv("DBNAME") . ";charset=utf8", getenv("DBUSER"), getenv("DBPASSWORD"));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  } catch (PDOException $e) {
    // If a connection error occurs, return null
    return null;
  }
}

// Executes a SQL query with optional parameters
function executeQuery(string $sql, ?array $params = null): ?PDOStatement
{
  // Check if there is a last query saved $_SESSION
  if (isset($_SESSION['lastQuery'])) {

    $deltaTime = time() - $_SESSION['lastQuery']['time'];
    // If the last query is the same as the current query, an too short amount of time has passed
    if ($_SESSION['lastQuery']['sql'] === $sql && $deltaTime < 2) {
      // die('Too many queries in a short amount of time');
      die('Trop de requêtes en peu de temps');
    }
  }
  $_SESSION['lastQuery']['time'] = time();
  $_SESSION['lastQuery']['sql'] = $sql;

  $db = db();
  if (!$db) {
    throw new RuntimeException("Database connection failed");
  }

  try {
    if ($params) {
      // Prepare the query with bound parameters
      $query = $db->prepare($sql);
      foreach ($params as $key => $value) {
        $query->bindValue($key, $value);
      }
      $query->execute();
      return $query;
    } else {
      // Execute the query without parameters
      return $db->query($sql);
    }
  } catch (PDOException $e) {
    // Handle and log the error
    error_log('Erreur : ' . $e->getMessage());
    return null;
  }
}
