<?php

require_once "../../logic/db.php";
require_once "../../logic/functions.php";
require_once "../../logic/user.class.php";

session_start();


$previous_page = get_previous_page();
$is_user_logged_in = isset($_SESSION['auth_user']);
$post_id = isset($_GET['id']) ? $_GET['id'] : null;
$has_error_occurred = false;

// get user & post data
if ($is_user_logged_in && $post_id) {
   $user = $_SESSION['auth_user'];

   $query = "SELECT `title`, `content`, `last_edited` FROM `post` WHERE `id` = $post_id";
   $conn = getConnection();
   $result = mysqli_query($conn, $query);

   if ($result && mysqli_num_rows($result) > 0) {
      $post = mysqli_fetch_assoc($result);
   }
   mysqli_close($conn);
} else {
   $has_error_occurred = true;
}

// delete post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $id = test_input($_POST['post_id']);

   $query = "DELETE FROM `post`";
   $query .= " WHERE `id` = $id";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      header('Location: all.php');
      exit();
   }
   mysqli_close($conn);
}

// --- END LOGIC ---
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update post</title>
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
            </ul>

            <form class="d-flex" role="search">
               <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
               <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>

            <div class="ms-lg-3">
               <?php if ($is_user_logged_in) { ?>

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
                        <li><a class="dropdown-item" href="logic/logout.php">Logout</a></li>
                     </ul>
                  </div>

               <?php
               } else { // @else is_user_logged_in
               ?>
                  <a href="register.php" role="button" class="btn btn-primary">Register</a>

               <?php
               } // @endif is_user_logged_in
               ?>
            </div>
         </div>
      </nav>
   </header>

   <div class="container py-5">
      <div class="col-md-5 mx-auto">
         <?php
         if ($has_error_occurred) {
            echo "Something went wrong <b>!!!</b> <a href='$previous_page' role='button' class='btn btn-primary'>Go back!</a>";
         } else {
         ?>
            <h5 class="mb-4">Are you sure you want to delete this post?</h5>

            <div class="card border-0 shadow--1 mb-3">
               <div class="card-body d-flex gap-3">
                  <img src="#" class="post-image" alt="Post image">
                  <div>
                     <h6 class="card-title"><?php echo $post['title'] ?></h6>
                     <p class="mb-2"><?php echo $post['content'] ?></p>
                     <small class="d-block fw-medium text-primary opacity-50">
                        <span>Me</span>
                        <span>&mdash;</span>
                        <span><?php echo $post['last_edited'] ?></span>
                     </small>
                  </div>
               </div>
            </div>

            <form class="d-grid gap-2" action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="POST">
               <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
               <div>
                  <button type="submit" class="btn btn-danger">Delete permanently !!!</button>
                  <a role="button" class="btn btn-outline-primary" href="<?php echo $previous_page ?>">Go back</a>
               </div>
            </form>

         <?php
         } // @endif has_error_occurred 
         ?>
      </div>
   </div>

   <?php include_once "../../components/bootstrap-js.php" ?>
</body>

</html>