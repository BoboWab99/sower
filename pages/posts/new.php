<?php

require_once "../../logic/functions.php";
require_once "../../logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
} else {
   header('Location: ../core/login.php');
   exit();
}

// save new post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $title = test_input($_POST['title']);
   $post = test_input($_POST['post']);

   $query = "INSERT INTO `post` (`title`, `content`, `author`)";
   $query .= "VALUES ('$title', '$post', $user->id);";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      header("Location: all.php");
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
   <title>New post</title>
   <?php include_once "../../components/bootstrap-css.php" ?>
   <link rel="stylesheet" href="../../css/app.css">
</head>

<body>

   <header class="header navbar navbar-expand-lg sticky-top bg-white shadow--1" id="header">
      <nav class="container bd-gutter flex-wrap flex-lg-nowrap" aria-label="Main navigation">
         <a class="navbar-brand" href="#">Sower</a>
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

   <div class="container py-5">
      <div class="col-md-8 col-lg-6 mx-auto">
         <h4 class="mb-3">Write a post</h4>
         <form class="d-grid gap-2" method="POST">
            <div class="form-field">
               <label for="form_title">Title:</label>
               <input type="text" name="title" class="form-control" id="form_title" required>
            </div>
            <div class="form-field">
               <label for="form_title">Post:</label>
               <textarea name="post" id="form_post" cols="30" rows="3" class="form-control" required></textarea>
            </div>
            <div>
               <button type="submit" class="btn btn-primary">Post</button>
               <button type="reset" class="btn btn-outline-primary">Reset</button>
            </div>
         </form>
      </div>
   </div>

   <?php include_once "../../components/bootstrap-js.php" ?>
</body>

</html>