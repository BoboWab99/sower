<?php
$path_prefix = "../../../";

require_once $path_prefix . "logic/functions.php";
require_once $path_prefix . "logic/user.class.php";

session_start();

$is_user_logged_in = isset($_SESSION['auth_user']);
if ($is_user_logged_in) {
   $user = $_SESSION['auth_user'];
} else {
   header("Location: " . $path_prefix . "pages/core/login.php");
   exit();
}

$users = [];
$query = "SELECT `id`, `username`, `first_name`, `last_name`, `email`, `tel`, `is_admin` FROM `user`";

$conn = getConnection();
if ($result = mysqli_query($conn, $query)) {
   while ($_user = mysqli_fetch_assoc($result)) {
      $users[] = $_user;
   }
}
mysqli_close($conn);


// --- END LOGIC ---
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>New post</title>
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <div class="layout-admin">
      <div class="row g-0 h-100">
         <?php include_once $path_prefix . "components/admin/nav.php" ?>

         <div class="col-9 col-xl-10">
            <?php include_once $path_prefix . "components/admin/header.php" ?>

            <div class="py-4 px-5 h-100 bg-light-primary overflow-auto">
               <div class="d-flex align-items-center gap-3 mb-4 pb-2">
                  <div class="flex-grow-1">
                     <h1 class="fs-3">Users</h1>
                  </div>
                  <a href="new.php" class="btn btn-primary plus-btn">New</a>
               </div>
               <div class="table-wrapper overflow-auto">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Username</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Tel</th>
                           <th>Is admin</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody class="table-group-divider">
                        <?php
                        $count = 0;
                        foreach ($users as $_user) {
                           $count++;
                        ?>
                           <tr>
                              <td class="fw-medium"><?php echo $count ?></td>
                              <td><?php echo "@" . $_user['username'] ?></td>
                              <td><?php echo $_user['first_name'] . " " . $_user['last_name'] ?></td>
                              <td><?php echo $_user['email'] ?></td>
                              <td><?php echo $_user['tel'] ?></td>
                              <td>
                                 <?php
                                 if ($_user['is_admin']) {
                                    echo '<span class="text-primary"><i class="fa-solid fa-check"></i></span>';
                                 } else {
                                    echo '<span class="text-secondary"><i class="fa-regular fa-circle-xmark"></i></span>';
                                 }
                                 ?>
                              </td>
                              <td>
                                 <a class="btn btn-sm border-white btn-outline-primary" href="<?php echo "update.php?id=" . $_user['id'] ?>">
                                    <i class="fa-solid fa-edit"></i>
                                 </a>
                                 <a class="btn btn-sm border-white btn-outline-danger" href="<?php echo "delete.php?id=" . $_user['id'] ?>">
                                    <i class="fa-solid fa-trash-can"></i>
                                 </a>
                              </td>
                           </tr>
                        <?php
                        }  // end @foreach user
                        ?>
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>

   <?php include_once $path_prefix . "components/js-links.php" ?>
</body>

</html>