<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$valErr = $confirmErr = "";
if (!empty($_POST)) {
    if (empty($_POST['email']) || empty($_POST['name']) || empty($_POST['password']) || empty($_POST['confirmpwd'])) {
        $valErr = "Field required";
    } else {
        $email = $_POST['email'];
        $name = $_POST['name'];

        if ($_POST['password'] != $_POST['confirmpwd']) {
            $confirmErr = "Passwords do not match";
        } else {
            $password = $_POST['password'];
        }
        $confirmpassword = $_POST['confirmpwd'];
        $hashedpwd = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(name,email,password) VALUES(:name,:email,:password)";

        $auth = $connect->prepare($sql);
        $auth->bindValue(':name', $name);
        $auth->bindValue(':email', $email);
        $auth->bindValue(':password', $hashedpwd);
        $auth->execute();

        $result = $connect->lastInsertId();

        if ($result) {
            logIn($result);
            redirect('index.php');
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
        <div>
    <form method = "post">
        Full Name:<input type="text" name="name"
        value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>"
        >
         <span class="error">* <?php echo $valErr;?></span>
         <br>
         <br>
        Email:<input type="email" name="email"
        value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>">
         <span class="error">* <?php echo $valErr;?></span>
        <br>
        <br>
        Password:<input type="password" name="password">
        <span class="error">* <?php echo $valErr;?></span>
        <br>
        <br>
        Confirm Password:<input type="password" name="confirmpwd">
         <span class="error">* <?php echo $valErr;?> <?php echo $confirmErr;?></span>
        <br>
        <br>
        <input type="submit" name="formSubmit" value="Submit">
    </form>
        </div>
</body>
</html>
