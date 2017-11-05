<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$nameErr = $emailErr = $pwdErr = $confirmErr = "";
if($_POST["formSubmit"]){

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmpwd'];
    $hashedpwd =  password_hash( $password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name,email,password) VALUES($name,$email,$password)";

    $auth = $connect->prepare($sql);
    $auth->bindValue(':name', $name);
    $auth->bindValue(':email', $email);
    $auth->bindValue(':password', $hashedpwd);
    $auth->execute();
}else{
    echo"An error occured!";
}
?>
<html>
    <head>
        <link rel="stylesheet" href="main.css" />
    </head>
    <body>
        <div>
    <form method = "post">
        Full Name:<input type="text" name="name">
         <span class="error">* <?php echo $nameErr;?></span>
         <br>
         <br>
        Email:<input type="email" name="email">
         <span class="error">* <?php echo $emailErr;?></span>
        <br>
        <br>
        Password:<input type="password" name="password">
        <span class="error">* <?php echo $pwdErr;?></span>
        <br>
        <br>
        Confirm Password:<input type="password" name="confirmpwd">
         <span class="error">* <?php echo $pwdErr;?> <?php echo $confirmErr;?></span>
        <br>
        <br>
        <input type="submit" name="formSubmit" value="Submit">
    </form>
        </div>
</body>
</html>
