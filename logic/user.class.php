<?php

require_once "db.php";


class User
{
   public $id;
   public $email;
   public $username;
   public $first_name;
   public $last_name;
   public $is_admin;
   public $is_super_admin;

   function __construct(
      $id,
      $email,
      $username,
      $first_name,
      $last_name,
      $is_admin,
      $is_super_admin
   ) {
      $this->id = $id;
      $this->email = $email;
      $this->username = $username;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->is_admin = $is_admin;
      $this->is_super_admin = $is_super_admin;
   }

   function __destruct()
   {
      return $this->username;
   }

   public static function create($email, $password)
   {
      $user = null;
      $query = "SELECT * FROM `user`";
      $query .= "WHERE `email` = '{$email}' AND `password` = '{$password}' LIMIT 1;";
      $conn = getConnection();

      if ($result =  mysqli_query($conn, $query)) {
         if (mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
            print_r($data);
            $user = new User(
               $data['id'],
               $data['email'],
               $data['username'],
               $data['first_name'],
               $data['last_name'],
               $data['is_admin'],
               $data['is_super_admin'],
            );
         }
      }

      mysqli_close($conn);
      return $user;
   }
}

// https://stackoverflow.com/questions/2169448/why-cant-i-overload-constructors-in-php