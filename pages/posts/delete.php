<?php

$path_prefix = "../../";

require_once $path_prefix . "logic/db.php";
require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

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
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <?php include_once $path_prefix . "components/header.php" ?>

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

   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>