<?php

require_once "logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
}

// path prefix
$path_prefix = "";

// --- END LOGIC ---
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sower</title>
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <?php include_once $path_prefix . "components/header.php" ?>

   <div class="container">
      <div class="col-md-6 mx-auto py-5">
         <h1 class="mb-3">Sower Home Page!</h1>
         <a class="btn btn-primary" href="<?php echo $path_prefix . "pages/core/login.php" ?>">Login</a>
         <a class="btn btn-outline-primary" href="<?php echo $path_prefix . "pages/core/register.php" ?>">Register</a>
      </div>
   </div>


   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>