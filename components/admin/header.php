<header class="header sticky-top bg-white border-bottom top-nav-height d-grid align-items-center" id="header">
   <nav class="d-flex justify-content-between flex-wrap flex-lg-nowrap gap-3 px-5 py-2" aria-label="Main navigation">
      <div></div>
      <div class="d-inline-flex gap-2">
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
      </div>
   </nav>
</header>