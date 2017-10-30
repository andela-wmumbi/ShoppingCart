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
    </head>
    <body>
    <form method="post">
        Email:<input type="text" name="email"><br>
        Password:<input type="password" name="password"><br>
        <input type="submit" name="formSubmit" value="Submit">
        </form>
    </body>
</html>

