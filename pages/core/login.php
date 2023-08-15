<?php

$path_prefix = "../../";

require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // get & validate data
   $email = test_input($_POST['email']);
   $password = test_input($_POST['password']);

   // make new user
   $user = User::create($email, $password);

   if ($user) {
      $_SESSION['auth_user'] = $user;              // authorized user
      $_SESSION['auth_user_id'] = $user->id;       // authorized user's id for quick access

      // if user is admin
      if ($user->is_admin) {
         header("Location: " . $path_prefix . "pages/admin/dashboard.php");
      } else {
         // normal user
         header("Location: " . $path_prefix . "pages/posts/all.php");
      }
   } else {
      $_SESSION['form_error'] = "Incorrect username or password!";
      header('Refresh:0');
   }
   exit();
}

// --- END LOGIC ---
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <?php include_once $path_prefix . "components/header.php" ?>

   <div class="py-5">
      <div class="col-10 col-md-7 col-lg-5 col-xl-4 mx-auto">

         <?php if ($is_user_logged_in) echo "<p class='badge text-bg-info text-wrap fw-medium w-100 py-2 lh-base'>You're already logged in <b>!!!</b> <br> <span class='fw-normal'>Logout to login with a different account!</span></p>" ?>

         <h3 class="mb-4">Login</h3>

         <?php
         // show login error
         if (isset($_SESSION['form_error'])) {
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>" . $_SESSION['form_error'] . "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            unset($_SESSION['form_error']);
         }
         ?>

         <form class="d-grid gap-3" method="POST" id="form">
            <div class="form-field">
               <label for="email">Email:</label>
               <input class="form-control" type="email" name="email" id="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="Enter Your Email" required autofocus>
            </div>

            <div class="form-field">
               <label for="password">Password:</label>
               <input class="form-control" type="password" name="password" id="password" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}" placeholder="Enter the password" required>
            </div>

            <div class="d-flex gap-2">
               <button class="btn btn-primary" type="submit" <?php if ($is_user_logged_in) echo "disabled" ?>>Login</button>
               <button class="btn btn-outline-primary" type="reset" <?php if ($is_user_logged_in) echo "disabled" ?>>Reset</button>
            </div>
         </form>
      </div>
   </div>


   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>