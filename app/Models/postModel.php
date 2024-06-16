<?php
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'DB.php';

function getNewPostRules()
{
  return [
    "rules" => [
      'newTitle' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 50,
      ],
      'newContent' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 420,
      ]
    ],
    'inputNames' => [
      'newTitle' => 'Titre',
      'newContent' => 'Contenu'
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
    ]
  ];
}
function getEditPostRules()
{
  return [
    "rules" => [
      'editContent' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 500,
      ]
    ],
    'inputNames' => [
      'editContent' => 'Contenu'
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
    ]
  ];
}

// Function to get the table name
function getTable()
{
  return 'posts';
}

// Function to create a new post
function createPost($title, $content)
{
  // Get the table name
  $table = getTable();
  $sql = "INSERT INTO $table (postTitle, postContent, postUserID) VALUES (:title, :content, :userId)";

  // Execute the query with prepared statements
  $response =  executeQuery($sql, [':title' => $title, ':content' => $content, ':userId' => $_SESSION['user']['id']]);
  if ($response->rowCount() === 0) {
    return ['error' => 'Le post n\'a pas été créé'];
  } else {
    return ['success' => 'Le post a été créé'];
  }
}

// Function to get all posts
function getPosts()
{
  // Get the table name
  $table = getTable();
  $sql = "SELECT * FROM $table INNER JOIN users ON $table.postUserID = users.useID ORDER BY $table.createdAt DESC";

  // Execute the query and fetch all results as objects
  return executeQuery($sql)->fetchAll(PDO::FETCH_OBJ);
}

// Function to get a single post by ID
function getPost($postID)
{
  // Get the table name
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE postID = :postID";

  // Execute the query with prepared statements and fetch the result as an object
  return executeQuery($sql, [':postID' => $postID])->fetch(PDO::FETCH_OBJ);
}

// Function to remove a post
function removePost($postID)
{
  // Check if user is logged in and owns the post
  $post = getPost($postID);
  if ($post->postUserID !== $_SESSION['user']['id']) {

    return ['error' => 'Vous devez être connecté pour supprimer un post'];
  }

  // Get the table name
  $table = getTable();
  $sql = "DELETE FROM $table WHERE postID = :postID";

  // Execute the query with prepared statements

  // return executeQuery($sql, [':postID' => $postID]);
  $response = executeQuery($sql, [':postID' => $postID]);
  if ($response->rowCount() === 0) {
    return ['error' => 'Le post n\'a pas été supprimé'];
  } else {
    return ['success' => 'Le post a été supprimé'];
  }
}

// Function to edit a post's content
function editPostContent($postID, $content)
{
  // Check if user is logged in and owns the post
  $post = getPost($postID);

  if ($post->postUserID !== $_SESSION['user']['id']) {
    return ['error' => 'Vous devez être connecté pourne pouvez pas modifier ce post'];
  }

  // Get the table name
  $table = getTable();
  $sql = "UPDATE $table SET postContent = :content WHERE postID = :postID AND postUserID = :userId";

  // Execute the query with prepared statements
  $response = executeQuery($sql, [':content' => $content, ':postID' => $postID, ':userId' => $_SESSION['user']['id']]);
  if ($response->rowCount() === 0) {
    return ['errors' => 'Le post n\'a pas été édité'];
  } else {
    return ['success' => 'Le post a été édité'];
  }
}
