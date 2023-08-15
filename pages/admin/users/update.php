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

$user_to_edit_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($user_to_edit_id) {
   // $user = $_SESSION['auth_user'];

   $query  = "SELECT `username`, `first_name`, `last_name`, `email`, `tel`";
   $query .= " FROM `user`";
   $query .= " WHERE `id` = $user_to_edit_id";

   $conn = getConnection();
   $result = mysqli_query($conn, $query);

   if ($result && mysqli_num_rows($result) > 0) {
      $user_to_edit = mysqli_fetch_assoc($result);
   } else {
      $has_user_id_error_occurred = true;
      header("Location: " . get_previous_page());
      exit();
   }
   mysqli_close($conn);
} else {
   $has_user_id_error_occurred = true;
   header("Location: " . get_previous_page());
   exit();
}

// save data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // $username = test_input($_POST['username']);
   $username = test_input($_POST['username']);
   $first_name = test_input($_POST['firstName']);
   $last_name = test_input($_POST['lastName']);
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

   $query  = "UPDATE `user`";
   $query .= " SET `username` = '$username', `first_name` = '$first_name',";
   $query .= " `email` = '$email', `tel` = '$tel', `password` = '$password'";
   $query .= " WHERE `id` = $user_to_edit_id";

   $conn = getConnection();
   if (mysqli_query($conn, $query)) {
      header('Location: all.php');
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
   <title>Update user</title>
   <?php include_once $path_prefix . "components/css-links.php" ?>
</head>

<body>

   <div class="layout-admin">
      <div class="row g-0 h-100">
         <?php include_once $path_prefix . "components/admin/nav.php" ?>

         <div class="col-9 col-xl-10">
            <?php include_once $path_prefix . "components/admin/header.php" ?>

            <div class="py-4 px-5 h-100 bg-light-primary overflow-auto">
               <div class="col-lg-6 mx-lg-auto">
                  <h1 class="fs-3 mb-4 pb-2">Update user info</h1>
                  <form class="d-grid gap-3" method="POST" id="form">
                     <div class="form-field">
                        <label for="username">Username:</label>
                        <input class="form-control" type="text" name="username" id="username" pattern="[a-zA-Z0-9_]{4,}" placeholder="Enter Your Username" required autofocus value="<?php echo $user_to_edit['username'] ?>">
                     </div>
                     <div class="d-flex flex-wrap gap-2">
                        <div class="form-field flex-grow-1">
                           <label for="firstName">First name:</label>
                           <input class="form-control" type="text" name="firstName" id="firstName" pattern="[a-z,A-Z,\s,'-,]{2,}" placeholder="Enter Your first name" required value="<?php echo $user_to_edit['first_name'] ?>">
                        </div>
                        <div class="form-field flex-grow-1">
                           <label for="lastName">Last name:</label>
                           <input class="form-control" type="text" name="lastName" id="lastName" pattern="[a-z,A-Z,\s,'-,]{2,}" placeholder="Enter Your last name" required value="<?php echo $user_to_edit['last_name'] ?>">
                        </div>
                     </div>
                     <div class="form-field">
                        <label for="email">Email:</label>
                        <input class="form-control" type="email" name="email" id="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" placeholder="Enter Your Email" required value="<?php echo $user_to_edit['email'] ?>">
                     </div>
                     <div class="form-field">
                        <label for="phoneNumber">Phone number:</label>
                        <input class="form-control" type="number" name="phoneNumber" id="phoneNumber" min="10" placeholder="Enter Your Number" required value="<?php echo $user_to_edit['tel'] ?>">
                     </div>
                     <div class="form-field">
                        <label for="password">Enter password:</label>
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

               <div style="min-height: 100vh;"></div>
            </div>
         </div>
      </div>
   </div>

   <?php include_once $path_prefix . "components/js-links.php" ?>
   <script src="<?php echo $path_prefix . "js/register.js" ?>"></script>

</body>

</html>