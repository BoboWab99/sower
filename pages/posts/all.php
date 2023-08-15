<?php

$path_prefix = "../../";

require_once $path_prefix . "logic/db.php";
require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

session_start();

// check if there's logged in user
$is_user_logged_in = isset($_SESSION['auth_user']);

if (!$is_user_logged_in) {
   header('Location: ../core/login.php');
   exit();
}

// save user info in a variable
$user = $_SESSION['auth_user'];

// sql statements
$query_tags = "SELECT * FROM `tag`";
$query_categories = "SELECT * FROM `category`";
$query_posts = "SELECT `post`.`id`, `title`, `content`, `last_edited`, `author`, `username` FROM `post` ";
$query_posts .= "INNER JOIN `user` ON `post`.`author` = `user`.`id`";

$tags = [];          // to store tags
$posts = [];         // to store posts
$categories = [];    // to store categories

// connection to db
$conn = getConnection();

// fetch tags
if ($result = mysqli_query($conn, $query_tags)) {
   if (mysqli_num_rows($result) > 0) {
      while ($tag = mysqli_fetch_assoc($result)) {
         $tags[] = $tag;
      }
   }
}

// fetch categories
if ($result = mysqli_query($conn, $query_categories)) {
   if (mysqli_num_rows($result) > 0) {
      while ($category = mysqli_fetch_assoc($result)) {
         $categories[] = $category;
      }
   }
}

// fetch posts
if ($result = mysqli_query($conn, $query_posts)) {
   if (mysqli_num_rows($result) > 0) {
      while ($post = mysqli_fetch_assoc($result)) {
         $posts[] = $post;
      }
   }
}

// close connection
mysqli_close($conn);

// save new post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // get & validate data
   $title = test_input($_POST['title']);
   $post = test_input($_POST['post']);

   // save to database
   $query = "INSERT INTO `post` (`title`, `content`, `author`)";
   $query .= "VALUES ('$title', '$post', $user->id);";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      header("Refresh: 0");
      exit();
   }

   // close connection,
   mysqli_close($conn);
}


// --- END LOGIC ---
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Posts</title>
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <?php include_once $path_prefix . "components/header.php" ?>

   <div class="main-posts">
      <div class="container-fluid gx-md-5">
         <div class="row g-3 g-lg-5">
            <div class="col-md-4 col-lg-3">
               <div class="latest pt-4 pb-5 mb-5">
                  <h6>Latest</h6>
                  <p>...</p>
               </div>
               <div class="popular pb-5">
                  <h6>Popular</h6>
                  <p>...</p>
               </div>
            </div>

            <div class="col-md-8 col-lg-9 bg-light-primary">
               <div class="col-10 col-lg-8 col-xl-6 mx-auto">
                  <div class="d-flex justify-content-between align-items-start gap-3 pt-4">
                     <h1 class="lh-1 fs-3">Posts</h1>
                     <a href="new.php" role="button" class="btn btn-primary plus-btn">Write</a>
                  </div>

                  <div class="py-3">
                     <p class="mb-1">Browse by categories or tags</p>
                     <div class="d-flex flex-wrap gap-1 mb-4 pb-2">
                        <!-- TODO: links for filtering!!! -->
                        <!-- loop through categories -->
                        <?php foreach ($categories as $category) { ?>
                           <a class="badge text-bg-primary text-capitalize" href="#"><?php echo $category['name'] ?></a>
                        <?php } ?>
                        <!-- loop through tags -->
                        <?php foreach ($tags as $tag) { ?>
                           <a class="badge text-bg-primary" href="#">#<?php echo $tag['name'] ?></a>
                        <?php } ?>
                     </div>
                  </div>

                  <!-- loop through posts -->
                  <div class="posts d-grid gap-2 pb-5">
                     <?php
                     foreach ($posts as $post) {
                     ?>
                        <div class="card border-0 shadow--1" data-href="<?php echo "details.php?id=" . $post['id'] ?>" tabindex="0" role="link">
                           <div class="card-body d-flex gap-3">
                              <img src="#" class="post-image" alt="Post image">
                              <div>
                                 <h6 class="card-title"><?php echo $post['title'] ?></h6>
                                 <p class="clip-text mb-2"><?php echo $post['content'] ?></p>
                                 <small class="d-block fw-medium text-success opacity-50">
                                    <span><?php echo "@" . $post['username'] ?></span>
                                    <span>&mdash;</span>
                                    <span><?php echo $post['last_edited'] ?></span>
                                 </small>

                                 <?php
                                 if ($post['author'] == $user->id) {
                                 ?>
                                    <div class="d-flex gap-2 mt-2">
                                       <a class="btn btn-sm btn-outline-primary" href="<?php echo "update.php?id=" . $post['id'] ?>">Edit</a>
                                       <a class="btn btn-sm btn-outline-danger" href="<?php echo "delete.php?id=" . $post['id'] ?>">Delete</a>
                                    </div>
                                 <?php
                                 }  // end @if user is author
                                 ?>
                              </div>
                           </div>
                        </div>
                     <?php
                     }  // end loop posts
                     ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>


   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>