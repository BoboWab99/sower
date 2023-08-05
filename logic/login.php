<?php

// require_once "db.php";
require_once "functions.php";
require_once "user.class.php";

session_start();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // get & validate data
   // $username = test_input($_POST['username']);
   $email = test_input($_POST['email']);
   $password = test_input($_POST['password']);

   // make new user
   $user = User::create($email, $password);

   if ($user) {
      $_SESSION['auth_user'] = $user;              // authorized user
      $_SESSION['auth_user_id'] = $user->id;       // authorized user's id
      header('Location: ../pages/core/posts.php');
   } else {
      // send some messages back
      header('Location: ../pages/core/login.php');
   }
   exit();
}

?>