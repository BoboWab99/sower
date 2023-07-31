<?php

require_once "./db.php";
require_once "./functions.php";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // get & validate data
   $username = test_input($_POST['username']);
   $firstName = test_input($_POST['firstName']);
   $lastName = test_input($_POST['lastName']);
   $email = test_input($_POST['email']);
   $tel = test_input($_POST['phoneNumber']);
   $password1 = test_input($_POST['password1']);
   $password2 = test_input($_POST['password2']);

   // save to database
   $query = "INSERT INTO `user` (`username`, `first_name`, `last_name`, `email`, `password`)";
   $query .= "VALUES ('{$username}', '{$firstName}', '{$lastName}', '{$email}', '{$password1}');";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      // go to login
      header('Location: ../pages/core/login.php');
      exit();
   } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
   }

   // close connection,
   mysqli_close($conn);
}

?>