<?php

require_once "./db.php";
require_once "./functions.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // get & validate data
   // $username = test_input($_POST['username']);
   $email = test_input($_POST['email']);
   $password = test_input($_POST['password']);

   // check data from db
   $query = "SELECT `id` FROM `user`";
   $query .= "WHERE `email` = '{$email}' AND `password` = '{$password}';";

   $conn = getConnection();
   if ($result = mysqli_query($conn, $query)) {
      if (mysqli_num_rows($result) > 0) {
         header('Location: ../pages/core/posts.php');
         exit();
      } else {
         // send some messages back
         header('Location: ../pages/core/login.php');
         exit();
      }
   } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
   }

   // close connection,
   mysqli_close($conn);
}

?>