<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$itemId = $_GET['id'];

// Confirm the selected itemId is in the DB
if (filter_var($itemId, FILTER_VALIDATE_INT)) {
    $sql = "SELECT * FROM item WHERE id=:itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();

    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}
/**
 * Obtain 'Add to cart' POST details
 * Update stock after adding an item to cart
 */
if (isset($_POST["cart"]) && filter_var($itemId, FILTER_VALIDATE_INT)) {
    $cart = [];
    $itemId = $_POST['itemId'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT id FROM item WHERE id = :itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();

    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    $cart = $_SESSION['cart'];
    if ($id) {
        $cart[$itemId] = $quantity;
        $_SESSION['cart'] = $cart;
        $sql = "UPDATE item SET stock=:stock WHERE id=:itemId";
        $stmt = $connect->prepare($sql);

        $stmt->bindValue(':stock', ($item['stock'] - $quantity));
        $stmt->bindValue(':itemId', $itemId);
        $stmt->execute();
        redirect('index.php');
    } else {
        echo "Item not found";
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
<?php
$disabled = "";
$message = "";
if ($item['stock'] == 0) {
    $disabled = "disabled";
    $message = "Out of stock";
}
echo '
<div class="display">
  <div class="card" style="width: 20rem;">
    <img class="card-img-top" src="./images/watch.jpg" alt="Card image cap">
    <div class="card-body">
      <h4>'.$item['name'].'</h4>
      <p>Stock: '.$item['stock'].''." ".$message.'</p>
      <p>Price: $'.$item['cost'].'</p>
    </div>
  </div>
</div>';
echo '
<form action="" method="post">
  <input type="hidden" name="itemId" value='.$item['id'].'>
    Qty: <input type="number" name="quantity" min="1" max="'.$item['stock'].'" value="1">
    <br>
    <br>
  <button type="submit" name="cart"'.$disabled.'>Add to cart</button>
'
?>
</div>
</html>
