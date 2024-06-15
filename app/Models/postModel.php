<?php
require_once dirname(__DIR__, 2) . DS . 'core' . DS . 'DB.php';

function getNewPostRules()
{
  return [
    "rules" => [
      'title' => [
        'required' => true,
        'minLength' => 2,
        'maxLength' => 50,
      ],
      'content' => [
        'required' => true,
        'minLength' => 8,
        'maxLength' => 500,
      ]
    ],
    'inputNames' => [
      'title' => 'Titre',
      'content' => 'Contenu'
    ],
    "errors" => [
      'required' => "Le champ %0% est requis.",
      'minLength' => "Le champ %0% doit contenir au moins %1% caractères.",
      'maxLength' => "Le champ %0% doit contenir au maximum %1% caractères.",
    ]
  ];
}

function getTable()
{
  return 'posts';
}


function createPost($title, $content)
{
  if ($_SESSION['user'] === null) {
    echo 'Vous devez être connecté pour créer un post';
    return false;
  }
  $table = getTable();
  $sql = "INSERT INTO $table (postTitle, postContent, postUserID) VALUES (:title, :content, :userId)";

  return executeQuery($sql, [':title' => $title, ':content' => $content, ':userId' => $_SESSION['user']['id']]);
}

function getPosts()
{
  $table = getTable();
  $sql = "SELECT * FROM $table INNER JOIN users ON posts.postUserID = users.useID ORDER BY posts.createdAt DESC";
  return executeQuery($sql)->fetchAll(PDO::FETCH_OBJ);
}

function getPost($postID)
{
  $table = getTable();
  $sql = "SELECT * FROM $table WHERE postID = :postID";
  return executeQuery($sql, [':postID' => $postID])->fetch(PDO::FETCH_OBJ);
}

function removePost($postID)
{
  $post = getPost($postID);
  if ($_SESSION['user'] === null || $post->postUserID !== $_SESSION['user']['id']) {
    echo 'Vous devez être connecté pour supprimer un post';
    return false;
  }

  $table = getTable();
  $sql = "DELETE FROM $table WHERE postID = :postID";
  return executeQuery($sql, [':postID' => $postID]);
}

function editPostContent($postID, $content)
{
  $post = getPost($postID);
  if ($_SESSION['user'] === null || $post->postUserID !== $_SESSION['user']['id']) {
    echo 'Vous devez être connecté pour supprimer un post';
    return false;
  }
  $table = getTable();
  $sql = "UPDATE $table SET postContent = :content WHERE postID = :postID AND postUserID = :userId";
  return executeQuery($sql, [':content' => $content, ':postID' => $postID, ':userId' => $_SESSION['user']['id']]);
}
