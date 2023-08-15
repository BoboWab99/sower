<?php
$path_prefix = "../../";

require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
} else {
   header("Location: " . $path_prefix . "pages/core/login.php");
   exit();
}

$user_count = 0;
$post_count = 0;
$comment_count = 0;

$user_count_query  = "SELECT COUNT(`id`) FROM `user`";
$post_count_query  = "SELECT COUNT(`id`) FROM `post`";
$comment_count_query  = "SELECT COUNT(`id`) FROM `comment`";

$conn = getConnection();
if ($result = mysqli_query($conn, $user_count_query)) {
   $user_count = mysqli_fetch_array($result)[0];
}
if ($result = mysqli_query($conn, $post_count_query)) {
   $post_count = mysqli_fetch_array($result)[0];
}
if ($result = mysqli_query($conn, $comment_count_query)) {
   $comment_count = mysqli_fetch_array($result)[0];
}
mysqli_close($conn);


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

   <div class="layout-admin">
      <div class="row g-0 h-100">
         <?php include_once $path_prefix . "components/admin/nav.php" ?>

         <div class="col-9 col-xl-10">
            <?php include_once $path_prefix . "components/admin/header.php" ?>

            <div class="py-4 px-5 h-100 bg-light-primary overflow-auto">
               <h1 class="fs-3 mb-4 pb-2">Dashboard</h1>
               <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                  <div class="col">
                     <div class="card border-light shadow" style="--bs-border-radius: .75rem">
                        <div class="card-body d-flex gap-3">
                           <div class="flex-grow-1">
                              <h6>Users</h6>
                              <h2 class="text-primary"><?php echo $user_count ?></h2>
                           </div>
                           <span class="square rounded fs-5">
                              <i class="fa-solid fa-users"></i>
                           </span>
                        </div>
                     </div>
                  </div>

                  <div class="col">
                     <div class="card border-light shadow" style="--bs-border-radius: .75rem">
                        <div class="card-body d-flex gap-3">
                           <div class="flex-grow-1">
                              <h6>Posts</h6>
                              <h2 class="text-primary"><?php echo $post_count ?></h2>
                           </div>
                           <span class="square rounded fs-5">
                              <i class="fa-solid fa-note-sticky"></i>
                           </span>
                        </div>
                     </div>
                  </div>

                  <div class="col">
                     <div class="card border-light shadow" style="--bs-border-radius: .75rem">
                        <div class="card-body d-flex gap-3">
                           <div class="flex-grow-1">
                              <h6>Comments</h6>
                              <h2 class="text-primary"><?php echo $comment_count ?></h2>
                           </div>
                           <span class="square rounded fs-5">
                              <i class="fa-solid fa-comments"></i>
                           </span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>