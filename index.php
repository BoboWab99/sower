<?php

require_once "logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
}

// --- END LOGIC ---
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Sower</title>
   <?php include_once "components/bootstrap-css.php" ?>
   <link rel="stylesheet" href="css/app.css">
</head>

<body>

   <header class="header navbar navbar-expand-lg sticky-top bg-white shadow--1" id="header">
      <nav class="container bd-gutter flex-wrap flex-lg-nowrap" aria-label="Main navigation">
         <a class="navbar-brand" href=".">Sower</a>
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
                  <a href="pages/core/login.php" role="button" class="btn btn-primary">Login</a>
               <?php
               } // @endif is_user_logged_in
               ?>
            </div>
         </div>
      </nav>
   </header>

   <div class="container">
      <div class="col-md-6 mx-auto py-5">
         <h1 class="mb-3">Sower Home Page!</h1>
         <a class="btn btn-primary" href="pages/core/login.php">Login</a>
         <a class="btn btn-outline-primary" href="pages/core/register.php">Register</a>
      </div>
   </div>


   <?php include_once "components/bootstrap-js.php" ?>
</body>

</html>