<?php

require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

if (loggedIn()) {
    redirect('index.php');
}
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if (!empty($password)) {
            $sql = "SELECT id FROM users WHERE email=:email AND password=:password";
            $auth = $connect->prepare($sql);
            $auth->bindValue(':email', $email);
            $auth->bindValue(':password', $password);
            $auth->execute();

            $result = $auth->fetchColumn();

            if ($result) {
                logIn($result);
                redirect('index.php');
            }
            echo "User not found";
        }
    }
}
?>
<html>
    <head>
        <link rel="stylesheet" href="main.css" />
        <link rel="stylesheet" href="css/bootstrap.min.css" />
    </head>
    <body>
    <div class="loginform">
        <form method="post" class="form">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div>
            <button type="submit" name="formSubmit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <p class="link" style="margin-top: 10px; line-height: 2.0;">
        <a href="./register.php">Create Account</a>
        </p>
    </div>
    </body>
</html>

