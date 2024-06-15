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
