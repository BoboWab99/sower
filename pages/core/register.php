<?php

require_once "../../logic/db.php";
require_once "../../logic/functions.php";
require_once "../../logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
}

// save data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $username = test_input($_POST['username']);
   $firstName = test_input($_POST['firstName']);
   $lastName = test_input($_POST['lastName']);
   $email = test_input($_POST['email']);
   $tel = test_input($_POST['phoneNumber']);
   $password1 = test_input($_POST['password1']);
   $password2 = test_input($_POST['password2']);
   $password = null;

   if ($password1 == $password2) {
      $password = password_hash($password1, PASSWORD_DEFAULT);
   } else {
      header('Refresh:0');
      exit();
   }

   $query = "INSERT INTO `user` (`username`, `first_name`, `last_name`, `email`, `password`)";
   $query .= "VALUES ('$username', '$firstName', '$lastName', '$email', '$password');";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      header('Location: login.php');
      exit();
      
   } else {
      echo "Error: " . $query . "<br>" . mysqli_error($conn);
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
   <title>Register</title>
   <?php include_once "../../components/bootstrap-css.php" ?>
   <link rel="stylesheet" href="../../css/app.css">
</head>

<body>

   <!-- https://stackoverflow.com/questions/18022809/how-to-solve-error-mysql-shutdown-unexpectedly -->
   <!-- https://stackoverflow.com/questions/768431/how-do-i-make-a-redirect-in-php -->

   <header class="header navbar navbar-expand-lg sticky-top bg-white shadow--1" id="header">
      <nav class="container bd-gutter flex-wrap flex-lg-nowrap" aria-label="Main navigation">
         <a class="navbar-brand" href="../../">Sower</a>
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
            </ul>

            <form class="d-flex" role="search">
               <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
               <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>

            <div class="ms-lg-3">
               <?php if ($is_user_logged_in) { ?>

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
                        <li><a class="dropdown-item" href="logic/logout.php">Logout</a></li>
                     </ul>
                  </div>

               <?php
               } else { // @else is_user_logged_in
               ?>
                  <a href="register.php" role="button" class="btn btn-primary">Register</a>

               <?php
               } // @endif is_user_logged_in
               ?>
            </div>
         </div>
      </nav>
   </header>

   <div class="py-5">
      <div class="col-10 col-md-7 col-lg-5 col-xl-4 mx-auto">
         <h4 class="mb-4">Register a new account</h4>

         <form class="d-grid gap-3" action="../../logic/register.php" method="POST" id="form">
            <div class="form-field">
               <label for="username">Username:</label>
               <input class="form-control" type="text" name="username" id="username" pattern="[a-zA-Z0-9_]{4,}" placeholder="Enter Your Username" required autofocus>
            </div>

            <div class="d-flex flex-wrap gap-2">
               <div class="form-field flex-grow-1">
                  <label for="username">First name:</label>
                  <input class="form-control" type="text" name="firstName" id="firstName" pattern="[a-z,A-Z,\s,'-,]{2,}" placeholder="Enter Your first name" required>
               </div>
               <div class="form-field flex-grow-1">
                  <label for="username">Last name:</label>
                  <input class="form-control" type="text" name="lastName" id="lastName" pattern="[a-z,A-Z,\s,'-,]{2,}" placeholder="Enter Your last name" required>
               </div>
            </div>

            <div class="form-field">
               <label for="email">Email:</label>
               <input class="form-control" type="email" name="email" id="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="Enter Your Email" required>
            </div>

            <div class="form-field">
               <label for="phoneNumber">Phone number:</label>
               <input class="form-control" type="number" name="phoneNumber" id="phoneNumber" min="10" placeholder="Enter Your Number" required>
            </div>

            <div class="form-field">
               <label for="password">Password:</label>
               <input class="form-control" type="password" name="password1" id="password1" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}" placeholder="Enter the password" required>
            </div>

            <div class="form-field">
               <label for="password">Confirm Password:</label>
               <input class="form-control" type="password" name="password2" id="password2" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}" placeholder="Enter the password" required>
            </div>

            <div class="d-flex gap-2">
               <button class="btn btn-primary" type="submit">Submit</button>
               <button class="btn btn-outline-primary" type="reset">Reset</button>
            </div>
         </form>
      </div>
   </div>


   <?php include_once "../../components/bootstrap-js.php" ?>

   <script>
      // some form validation
      const form = document.getElementById('form')
      const password1 = document.getElementById('password1')
      const password2 = document.getElementById('password2')

      form.addEventListener('submit', (e) => {
         e.preventDefault()

         if (password1.value != password2.value) {
            password2.setCustomValidity('Passwords do not match!')
            password2.reportValidity()
            return
         } else {
            password2.setCustomValidity('')
         }

         form.submit()
      })
   </script>

</body>

</html>