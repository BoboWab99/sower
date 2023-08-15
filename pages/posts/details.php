<?php

$path_prefix = "../../";

require_once $path_prefix . "logic/db.php";
require_once $path_prefix . "logic/main.php";
require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

session_start();


$previous_page = get_previous_page();
$is_user_logged_in = isset($_SESSION['auth_user']);
$post_id = isset($_GET['id']) ? $_GET['id'] : null;
$has_error_occurred = false;
$model = Model::$POST;

if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
}

// post details
if ($post_id) {
   $query  = "SELECT `post`.`id`, `title`, `content`, `last_edited`, `author`, `username`";
   $query .= " FROM `post`";
   $query .= " INNER JOIN `user` ON `post`.`author` = `user`.`id`";
   $query .= " WHERE `post`.`id` = $post_id";
   $conn = getConnection();
   $result = mysqli_query($conn, $query);

   if ($result && mysqli_num_rows($result) > 0) {
      $post = mysqli_fetch_assoc($result);
      $comments = [];

      // comments
      $_query  = "SELECT `comment`.`id`, `content`, `last_edited`, `user_id`, `username`";
      $_query .= " FROM `comment`";
      $_query .= " INNER JOIN `user` ON `comment`.`user_id` = `user`.`id`";
      $_query .= " WHERE `model` = $model AND `model_id` = " . $post['id'];
      $_result = mysqli_query($conn, $_query);
      if (mysqli_num_rows($result) > 0) {
         while ($row = mysqli_fetch_assoc($_result)) {
            $comments[] = $row;
         }
      }
   }
   mysqli_close($conn);
} else {
   $has_error_occurred = true;
}

// save comment
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   if (!$is_user_logged_in) {
      header('Location' . $path_prefix . 'pages/core.login.php');
      exit();
   }

   $post_id = test_input($_POST['post_id']);
   $comment = test_input($_POST['comment']);

   $query = "INSERT INTO `comment` (`content`, `model`, `model_id`, `user_id`)";
   $query .= " VALUES('$comment', '$model', '$post_id', $user->id)";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      header('Refresh:0');
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

   <div class="main-post-details bg-light-primary">
      <div class="container-fluid py-5">
         <div class="col-md-8 col-lg-6 col-xl-5 mx-auto">
            <?php
            if ($has_error_occurred) {
               echo "Something went wrong <b>!!!</b> <a href='$previous_page' role='button' class='btn btn-primary'>Go back!</a>";
            } else {
            ?>
               <div class="card border-0 shadow--1 mb-3" style="--bs-border-radius: .75rem">
                  <div class="card-body p-4">
                     <div class="d-grid gap-3">
                        <div class="d-flex gap-3">
                           <span class="circle text-uppercase mt-1"><?php echo substr($post['username'], 0, 1); ?></span>
                           <div>
                              <h6 class="card-title mb-0"><?php echo $post['title'] ?></h6>
                              <small class="fw-medium text-primary opacity-50">
                                 <span><?php echo "@" . $post['username'] ?></span>
                                 <span>&mdash;</span>
                                 <span><?php echo $post['last_edited'] ?></span>
                              </small>
                           </div>
                        </div>
                        <div>
                           <img src="#" class="card-img-top img-hd" alt="Post image">
                        </div>
                        <div>
                           <p class="mb-0"><?php echo $post['content'] ?></p>
                        </div>
                     </div>

                     <hr class="border-2 my-4 opacity-75">

                     <div class="comments-wrapper">
                        <h3 class="fs-6 mb-3">Comments</h3>
                        <form class="d-flex gap-2 mb-3" method="POST" style="--bs-border-radius: .375rem">
                           <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
                           <textarea name="comment" id="" cols="30" rows="10" class="form-control rows-1"></textarea>
                           <button type="submit" class="btn btn-primary">Comment</button>
                        </form>

                        <div role="list" class="comments-wrapper-inner">
                           <?php
                           if (!$comments) {
                              echo '<div role="listitem" class="text-danger"><small>No comments!!!</small></div>';
                           } else {
                              foreach ($comments as $comment) {
                           ?>
                                 <div role="listitem" class="d-flex gap-3">
                                    <span class="circle text-uppercase mt-1"><?php echo substr($comment['username'], 0, 1); ?></span>
                                    <div>
                                       <small class="fw-medium text-primary opacity-50">
                                          <span><?php echo "@" . $comment['username'] ?></span>
                                          <span>&mdash;</span>
                                          <span><?php echo $comment['last_edited'] ?></span>
                                       </small>
                                       <p><?php echo $comment['content'] ?></p>
                                    </div>
                                 </div>
                           <?php
                              }
                           }
                           ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php
            } // @endif has_error_occurred
            ?>
         </div>
      </div>
   </div>

   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>