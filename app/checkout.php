<?php
?>
<html>
  <head>
     <link rel="stylesheet" href="main.css">
      <link rel="stylesheet" href="css/bootstrap.min.css" />
  </head>
<div>
<?php include_once "./header.html"?>
</div>
<div>
<?php include_once "./cartView.php"?>
<div class="checkout title">Please enter your details</div>
<form method="post"class="checkout">
  <div class="form-group">
    <label class="col-form-label" for="formGroupExampleInput">Address</label>
    <input type="text" class="form-control" placeholder="1211283 lois avenue"
       name="address">
  </div>
  <div class="form-group">
    <label class="col-form-label">Phone number</label>
    <input type="text" class="form-control" placeholder="+254723******"
      name="number">
  </div>
  <button type="button" class="btn btn-primary">Order</button>
</form>
</div>
</html>
