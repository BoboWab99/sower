<?php

require_once "db.php";
require_once "functions.php";

// sql statements
$query_tags = "SELECT * FROM `tag`";
$query_posts = "SELECT * FROM `post`";
$query_categories = "SELECT * FROM `category`";

$tags = [];          // to store tags
$categories = [];    // to store categories
$posts = [];         // to store posts

// connection to db
$conn = getConnection();

// fetch tags
if ($result = mysqli_query($conn, $query_tags)) {
   if (mysqli_num_rows($result) > 0) {
      while($tag = mysqli_fetch_assoc($result)) {
         $tags[] = $tag;
      }
   }
} else {
   echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

// fetch categories
if ($result = mysqli_query($conn, $query_categories)) {
   if (mysqli_num_rows($result) > 0) {
      while($category = mysqli_fetch_assoc($result)) {
         $categories[] = $category;
      }
   }
} else {
   echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

// fetch posts
if ($result = mysqli_query($conn, $query_posts)) {
   if (mysqli_num_rows($result) > 0) {
      while($post = mysqli_fetch_assoc($result)) {
         $posts[] = $post;
      }
   }
} else {
   echo "Error: " . $query . "<br>" . mysqli_error($conn);
}

// close connection,
mysqli_close($conn);


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // get & validate data
   $title = test_input($_POST['title']);
   $post = test_input($_POST['post']);

   // save to database
   $query = "INSERT INTO `post` (`title`, `content`, `author`)";
   $query .= "VALUES ('{$title}', '{$post}', 4);";

   $conn = getConnection();

   if (mysqli_query($conn, $query)) {
      // go back to posts
      header('Location: ../pages/core/posts.php');
      exit();
   } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
   }

   // close connection,
   mysqli_close($conn);
}

?>