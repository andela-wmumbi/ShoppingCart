<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$emailErr = $passwordErr = $valErr = $error = "";
if (loggedIn()) {
    redirect('index.php');
}
if (!empty($_POST)) {
    empty(trim($_POST['email'])) ? $emailErr = "Email required" : "";
    empty(trim($_POST['password'])) ? $passwordErr = "Password required" : "";
    (!empty(trim($_POST['email'])) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? $valErr = "Enter a valid email" : "";
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT password FROM users WHERE email=:email";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchColumn();
    if ($result) {
        if (password_verify($password, $result)) {
            $sql = "SELECT id FROM users WHERE email=:email AND password=:password";
            $auth = $connect->prepare($sql);
            $auth->bindValue(':email', $email);
            $auth->bindValue(':password', $password);
            $auth->execute();

            $id = $auth->fetchColumn();
            logIn($id);
            redirect('index.php');

        } else {
            $error = "Wrong Password";
        }
    } else {
          $error = "User not found";
    }
}
?>
<html>
<head>
    <link rel="stylesheet" href="main.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<div class="create">Login into your account</div>
<div class="loginform">
  <div class="err"><span class="error"><?php echo $error;?></span></div>
  <form method="post" class="form">
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="email" name="email" class="form-control"
        id="exampleInputEmail1" aria-describedby="emailHelp"
        placeholder="Enter email">
      <span class="error">* <?php echo $emailErr;?><?php echo $valErr;?></span>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" name="password" class="form-control"
        id="exampleInputPassword1" placeholder="Password">
      <span class="error">* <?php echo $passwordErr;?></span>
    </div>
    <div>
    <button type="submit" name="formSubmit" class="btn btn-primary">Submit</button>
    <a href="./register.php">Create Account</a>
    </div>
  </form>
  </p>
</div>
</body>
</html>
