<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$emailErr = $nameErr = $passwordErr = $confirmErr = $valErr = "";

if (isset($_POST["formSubmit"])) {
    empty(trim($_POST['email'])) ? $emailErr = "Field required" : "";
    empty(trim($_POST['name'])) ?  $nameErr = "Field required" : "";
    empty(trim($_POST['password'])) ? $passwordErr = "Field required" : "";
    empty(trim($_POST['confirmpwd'])) ? $confirmErr = "Field required" : "";
    (!empty(trim($_POST['email'])) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) ? $valErr = "Enter a valid email" : "";

    ($_POST['password'] !== $_POST['confirmpwd']) ? $confirmErr = "Passwords do not match" : "";

    if (!$emailErr && !$nameErr && !$passwordErr && !$confirmErr) {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $hashedpwd = password_hash($password, PASSWORD_DEFAULT);

        $sql = "SELECT email FROM users WHERE email=:email";
        $stmt = $connect->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        if ($result) {
            $emailErr = "Email already exists";
        } else {
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
}
?>
<html>
<head>
  <link rel="stylesheet" href="main.css" />
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body>
<div class="create">Create an account</div>
<div>
  <form method = "post"  class="form">
    <div class="form-group">
      <label>Full name</label>
      <input type="text" name="name" class="form-control"
        placeholder="Enter fullname"
        value="<?php echo isset($_POST['name']) ? $_POST['name'] : '';?>">
      <span class="error">* <?php echo $nameErr;?></span>
    <div class="form-group">
      <label for="exampleInputEmail1">Email address</label>
      <input type="text" name="email" class="form-control"
        id="exampleInputEmail1" aria-describedby="emailHelp"
        placeholder="Enter email"
        value="<?php echo isset($_POST['email']) ? $_POST['email'] : '';?>">
      <span class="error">* <?php echo $emailErr;?><?php echo $valErr;?></span>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" name="password" class="form-control"
        id="exampleInputPassword1" placeholder="Password">
      <span class="error">* <?php echo $passwordErr;?></span>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Confirm Password</label>
      <input type="password" name="confirmpwd" class="form-control"
        id="exampleInputPassword1" placeholder="Password">
      <span class="error">* <?php echo $confirmErr;?></span>
    <button type="submit" name="formSubmit" class="btn btn-primary">Submit</button>
  </form>
</div>
</div>
</body>
</html>
