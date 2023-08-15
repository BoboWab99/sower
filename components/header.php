<?php

// start session if it isn't started
if (session_id() == '' || !isset($_SESSION) || session_status() === PHP_SESSION_NONE) {
   session_start();

   // is user logged in?
   $is_user_logged_in = isset($_SESSION['auth_user']);

   if ($is_user_logged_in) {
      $user = $_SESSION['auth_user'];
   }
}

?>


<header class="header navbar navbar-expand-lg sticky-top bg-white shadow--1" id="header">
   <nav class="container-fluid gx-5 flex-wrap flex-lg-nowrap" aria-label="Main navigation">
      <a class="navbar-brand" href="<?php echo $path_prefix . "index.php" ?>">Sower</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
         <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
               <a class="nav-link active" href="<?php echo $path_prefix . "index.php" ?>">Home</a>
            </li>
            <li class="nav-item">
               <a class="nav-link active" href="<?php echo $path_prefix . "pages/posts/all.php" ?>">Posts</a>
            </li>
            <!-- <li class="nav-item dropdown">
               <a class="nav-link" href="#">Another link...</a>
            </li> -->
         </ul>

         <form class="d-flex mx-auto" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary" type="submit">Search</button>
         </form>

         <div class="ms-lg-3 d-inline-flex gap-2">
            <?php
            if ($is_user_logged_in) {  // @if is_user_logged_in
            ?>
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
                     <li><a class="dropdown-item" href="<?php echo $path_prefix . "logic/logout.php" ?>">Logout</a></li>
                  </ul>
               </div>

            <?php
            } else { // @else is_user_logged_in
            ?>
               <a href="<?php echo $path_prefix . "pages/core/register.php" ?>" role="button" class="btn btn-primary">Register</a>
               <a href="<?php echo $path_prefix . "pages/core/login.php" ?>" role="button" class="btn btn-outline-primary">Login</a>
            <?php
            } // @endif is_user_logged_in
            ?>
         </div>
      </div>
   </nav>
</header>