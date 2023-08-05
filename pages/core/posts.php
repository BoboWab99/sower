<?php

require_once "../../logic/posts.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Posts</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
   <link rel="stylesheet" href="../../css/app.css">
   <style>
      .navbar {
         --bs-navbar-padding-y: .75rem;
      }

      .navbar-brand {
         color: #12b212;
         font-weight: 500;
      }
   </style>
</head>

<body>

   <header class="header navbar navbar-expand-lg sticky-top shadow--1" id="header">
      <nav class="container bd-gutter flex-wrap flex-lg-nowrap" aria-label="Main navigation">
         <a class="navbar-brand" href="#">Sower</a>
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
               <li class="nav-item">
                  <a class="nav-link disabled" aria-disabled="true">Disabled</a>
               </li>
            </ul>
            <form class="d-flex" role="search">
               <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
               <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            <div class="ms-lg-3">
               <div class="dropdown">
                  <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                     <?php echo $user->username; ?>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                     <li><a class="dropdown-item" href="#">Action</a></li>
                     <li><a class="dropdown-item" href="#">Another action</a></li>
                     <li>
                        <hr class="dropdown-divider">
                     </li>
                     <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
               </div>
            </div>
         </div>
      </nav>
   </header>

   <div class="container py-4">
      <div class="row g-3 g-lg-5">
         <div class="col-md-5 col-lg-3">
            <h6 class="mb-3">Write a post</h6>
            <form class="d-grid gap-2" action="../../logic/posts.php" method="POST">
               <div class="form-field">
                  <label for="form_title">Title:</label>
                  <input type="text" name="title" class="form-control" id="form_title" required>
               </div>
               <div class="form-field">
                  <label for="form_title">Post:</label>
                  <textarea name="post" id="form_post" cols="30" rows="3" class="form-control" required></textarea>
               </div>
               <div>
                  <button type="submit" class="btn btn-primary">Post</button>
               </div>
            </form>
         </div>

         <div class="col-md-7 col-lg-9">
            <h3>Posts</h3>
            <p class="mb-1">Browse by categories or tags</p>
            <div class="d-flex flex-wrap gap-1 mb-4 pb-2">

               <!-- TODO: links for filtering!!! -->

               <!-- loop through categories -->
               <?php foreach ($categories as $category) { ?>
                  <a class="badge text-bg-primary" href="#"><?php echo $category['name'] ?></a>
               <?php } ?>

               <!-- loop through tags -->
               <?php foreach ($tags as $tag) { ?>
                  <a class="badge text-bg-primary" href="#"><?php echo $tag['name'] ?></a>
               <?php } ?>
            </div>

            <!-- loop through posts -->
            <div class="posts d-grid gap-2">
               <?php foreach ($posts as $post) { ?>
                  <div class="card border-0 shadow--1">
                     <div class="card-body d-flex gap-3">
                        <img src="#" class="post-image" alt="Post image">
                        <div>
                           <h6 class="card-title"><?php echo $post['title'] ?></h6>
                           <p class="mb-0"><?php echo $post['content'] ?></p>
                        </div>
                     </div>
                  </div>
               <?php } ?>
            </div>

         </div>
      </div>
   </div>


   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>