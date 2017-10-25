<?php

use includes\session;
use includes\db;

  if (!empty($_POST))
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if(!empty($password)){
      $valEmail = mysqli_real_escape_string($connect, $email);
      $valPass = mysqli_real_escape_string($connect, $password);

      $sql = 

      }
    }
  }
?>
<form method="post">
  Email:<input type="text" name="email"><br>
  Password:<input type="password" name="password"><br>
  <input type="submit" name="formSubmit" value="Submit">
</form>
