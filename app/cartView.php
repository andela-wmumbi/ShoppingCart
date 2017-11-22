<?php

require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

/**
 * Obtain POST delete details
 * Remove item from cart
 * Update items stock
 */
if (isset($_POST["delete"])) {
    $items = $_SESSION['cart'];
    $itemId = $_POST['itemId'];
    $oldQuantity = $items[$itemId];
    unset($items[$itemId]);
    $_SESSION['cart'] = $items;

    $currentStock = $_POST['itemStock'];
    $sql = "UPDATE item SET stock=:stock WHERE id=:itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':stock', ($currentStock + $oldQuantity));
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();
}
/**
 * Obtain the new item quantity
 * Update session cart with the new quantity
 * Update item stock
 */
if (isset($_POST['update'])) {
    $items = $_SESSION['cart'];
    $itemId = $_POST['itemId'];
    $oldQuantity = $items[$itemId];
    $newQuantity = $_POST['quantity'];
    $currentStock = $_POST['itemStock'];
    $items[$itemId] = $_POST['quantity'];
    $_SESSION['cart'] = $items;

    $sql = "UPDATE item SET stock=:stock WHERE id=:itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':stock', ($currentStock + $oldQuantity - $newQuantity));
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();
}
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

?>
<html>
<head>
  <link rel="stylesheet" href="main.css">
  <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<div>
<?php include_once "./header.html"?>
</div>
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
                  <li>Price: $'.$item['cost'].'</li>
                </ul>
                <form action="" method="post">
                  <input type="hidden" name="itemId" value='.$item['id'].'>
                  <input type="hidden" name="itemStock" value='.$item['stock'].'>
                  <button type="submit" name="delete">Delete</button>
                </form>
              </div>
            </td>
            <td class="v1">'.$item['cost'].'</td>
            <td>
              <form action="" method="post">
                <input type="hidden" name="itemId" value='.$item['id'].'>
                <input type="hidden" name="itemStock" value='.$item['stock'].'>
                <input type="number" name="quantity" min="1"
                  max="'.$item['stock'].'" value="'.$items[$item['id']].'">
                <button type="submit" name="update">Update</button>
              </form>
            </td>
          </tr>';
    }
    ?>
  </table>
<hr>
<?php echo ($result ? '<a href="checkout.php">Checkout</a>' : "")?>
</div>
</html>
