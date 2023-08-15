<?php
$path_prefix = "../../";

require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

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
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <?php include_once $path_prefix . "components/header.php" ?>

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

   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>