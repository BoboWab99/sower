<?php

require_once "../../logic/db.php";
require_once "../../logic/functions.php";
require_once "../../logic/user.class.php";

session_start();

// check if there's logged in user
if (!isset($_SESSION['auth_user'])) {
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
   <?php include_once "../../components/bootstrap-css.php" ?>
   <link rel="stylesheet" href="../../css/app.css">
</head>

<body>

   <header class="header navbar navbar-expand-lg sticky-top bg-white shadow--1" id="header">
      <nav class="container bd-gutter flex-wrap flex-lg-nowrap" aria-label="Main navigation">
         <a class="navbar-brand" href="../../">Sower</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
               <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#">Home</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#">Link</a>
               </li>
               <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     Dropdown
                  </a>
                  <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="#">Action</a></li>
                     <li><a class="dropdown-item" href="#">Another action</a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
               </li>
               <!-- <li class="nav-item">
                  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
               </li> -->
            </ul>

            <form class="d-flex" role="search">
               <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
               <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>

            <div class="ms-lg-3">
               <div class="dropdown">
                  <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php echo "@" . $user->username; ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                     <li>
                        <div class="px-4 pt-1 pb-2 text-center">
                           <h6 class="mb-0 text-capitalize"><?php echo $user->full_name; ?></h6>
                           <a class="d-block" href="mailto:<?php echo $user->email; ?>"><?php echo $user->email; ?></a>
                           <span class="d-block"><?php echo "@" . $user->username; ?></span>
                        </div>
                     </li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="#">My Posts</a></li>
                     <li><a class="dropdown-item" href="#">Profile</a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="../../logic/logout.php">Logout</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
   </header>

   <div class="container py-4">
      <div class="row g-3 g-lg-5">
         <div class="col-md-5 col-lg-3">
            <div class="latest pb-5 mb-5">
               <h6>Latest</h6>
            </div>
            <div class="popular">
               <h6>Popular</h6>
            </div>
         </div>

         <div class="col-md-7 col-lg-9">
            <div class="d-flex justify-content-between align-items-start gap-3">
               <h1 class="lh-1">Posts</h1>
               <a href="new.php" role="button" class="btn btn-primary plus-btn">Write</a>
            </div>
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

            <!-- loop through posts -->
            <div class="posts d-grid gap-2">
               <?php foreach ($posts as $post) { ?>
                  <div class="card border-0 shadow--1">
                     <div class="card-body d-flex gap-3">
                        <img src="#" class="post-image" alt="Post image">
                        <div>
                           <h6 class="card-title"><?php echo $post['title'] ?></h6>
                           <p class="mb-2"><?php echo $post['content'] ?></p>

                           <small class="d-block fw-medium text-success opacity-50">
                              <span><?php echo "@" . $post['username'] ?></span>
                              <span>&mdash;</span>
                              <span><?php echo $post['last_edited'] ?></span>
                           </small>

                           <?php if ($post['author'] == $user->id) { ?>
                              <a class="me-2" href="../posts/update.php?id=<?php echo $post['id'] ?>">Edit</a>
                              <a class="text-danger" href="../posts/delete.php?id=<?php echo $post['id'] ?>">Delete</a>
                           <?php } ?>
                        </div>
                     </div>
                  </div>
               <?php } ?>
            </div>

         </div>
      </div>
   </div>


   <?php include_once "../../components/bootstrap-js.php" ?>
</body>

</html>