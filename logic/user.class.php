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
   public $full_name;

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
      $this->full_name = "$this->first_name $this->last_name";
   }

   function __destruct()
   {
      return $this->username;
   }

   public static function create($email, $password)
   {
      $user = null;
      $query = "SELECT * FROM `user`";
      $query .= "WHERE `email` = '$email' LIMIT 1;";
      $conn = getConnection();
      $result =  mysqli_query($conn, $query);

      if ($result && mysqli_num_rows($result) > 0) {
         $data = mysqli_fetch_assoc($result);
         $hashed_password = $data['password'];
         // print_r($data);

         if (password_verify($password, $hashed_password)) {
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