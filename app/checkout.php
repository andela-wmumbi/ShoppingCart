<?php

require '../includes/session.php';
require '../includes/db.php';
require '../includes/utils.php';

/**
 * Fetch all details of item ids in cart
 * Display the details
 */
$result = [];
if (isset($_SESSION['cart'])) {
    $items = $_SESSION['cart'];
    $itemsIds = implode(",", array_keys($items));
    $sql = "SELECT * FROM item WHERE id IN ($itemsIds)";
    $stmt = $connect->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll();
}
$addressErr = $numberErr = $phoneErr =  "";
if (isset($_POST["order"])) {
      // Validate all fields
      empty(trim($_POST['address'])) ? $addressErr = "Address required" : "";
      empty(trim($_POST['number'])) ? $numberErr = "Phone number required" : "";
      (!empty(trim($_POST['number'])) && !filter_var($_POST['number'], FILTER_VALIDATE_INT)) ?
      $phoneErr = "Enter a valid phone number" : "";

      $address = $_POST['address'];
      $phone = $_POST['number'];

      $userId = $_SESSION['currentUserId'];

      $sql = "INSERT INTO orders(address, phonenumber, userId) VALUES(:address, :number, :userId)";
      $stmt = $connect->prepare($sql);
      $stmt->bindValue(':address', $address);
      $stmt->bindValue(':number', $phone);
      $stmt->bindValue(':userId', $userId);

      $stmt->execute();

      // save order item
      $orderId = $connect->lastInsertId();

      if(!empty($_SESSION['cart'])) {
        $items = $_SESSION['cart'];
        $itemsIds = implode(",", array_keys($items));
        $sql = "SELECT * FROM item WHERE id IN ($itemsIds)";
        $stmt = $connect->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $sql = "INSERT INTO order_items(name,quantity,unitCost,orderId,itemId)
                VALUES(:name,:quantity,:cost,:orderId,:itemId)";
        $stmt = $connect->prepare($sql);
        foreach($result as $key => $item){
              $stmt->bindValue(':name', $item['name']);
              $stmt->bindValue(':quantity', $items[$item['id']]);
              $stmt->bindValue(':cost', $item['cost']);
              $stmt->bindValue(':orderId', $orderId);
              $stmt->bindValue(':itemId', $item['id']);
              $stmt->execute();

              $result = $stmt->fetchColumn();
        }
        if($result) {
            $_SESSION['cart'] = [];
            redirect('index.php');
        }
      }
}

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
<div class="cartview">
<?php
$disabled = "";
echo (!$result ? 'No items in cart' : '
  <table border="0">
    <hr>
    <tr>
      <th colspan="2"> Shopping</th>
      <th> Price</th>
      <th> Quantity</th>
    </tr>');
?>
<?php foreach ($result as $key => $item) {
    echo '
      <tr>
        <td>
        <span><img class="card-img-top" src="./images/watch.jpg"
          alt="Card image cap"></span>
        </td>
        <td class="v1">
          <div>
            <ul>
              <li><span>'.$item['name'].'</span></li>
              <li>Stock: '.$item['stock'].'</li>
            </ul>
          </div>
        </td>
        <td class="v1">'.$item['cost'].'</td>
        <td>'.$items[$item['id']].'</td>
      </tr>';
}
?>
  </table>
<hr>
</div>
<div class="checkout title">Please enter your details</div>
<form method="post" class="checkout">
  <div class="form-group">
    <label class="col-form-label" for="formGroupExampleInput">Address</label>
    <input type="text" class="form-control" placeholder="1211283 lois avenue"
       name="address">
    <span class="error">* <?php echo $addressErr;?></span>
  </div>
  <div class="form-group">
    <label class="col-form-label">Phone number</label>
    <input type="" class="form-control" placeholder="+254723******"
      name="number">
    <span class="error">* <?php echo $numberErr;?><?php echo $phoneErr;?></span>
  </div>
<?php
$disabled = "";
if(!$result) {
  $disabled = "disabled";
}
echo'<button type="submit" class="btn btn-primary" name="order" '.$disabled.'>Order</button>'
?>
</form>
</div>
</html>
