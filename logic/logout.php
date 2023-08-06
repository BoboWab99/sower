<?php

session_start();

if (isset($_SESSION['auth_user'], $_SESSION['auth_user_id'])) {
   unset($_SESSION['auth_user']);
   unset($_SESSION['auth_user_id']);
   header('Location: ../pages/core/login.php');
   exit();
}

?>