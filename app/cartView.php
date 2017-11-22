<?php

require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$items = $_SESSION['cart'];

if ($_POST["delete"]) {
    $itemId = $_POST['itemId'];
    unset($items[$itemId]);
    $_SESSION['cart'] = $items;
}
if ($_POST == 'update') {
    $itemId = $_POST['itemId'];
    $items[$itemId] = $item['stock'] ;
}

if (count($items) == 0) {
    echo "No items in cart";
}
$itemsIds = implode(",", array_keys($items));
$sql = "SELECT * FROM item WHERE id IN ($itemsIds)";
$stmt = $connect->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();

?>
<html>
<head>
  <link rel="stylesheet" href="main.css">
</head>
<div>
  <table border="0">
    <hr>
    <tr>
        <th colspan="2"> Shopping</th>
        <th> Price</th>
        <th> Quantity</th>
    </tr>
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
                  <li>'.$item['stock'].'</li>
                  <li>'.$item['cost'].'</li>
                </ul>
                <form action="" method="post">
                  <input type="hidden" name="itemId" value='.$item['id'].'>
                  <button type="submit" name="delete">Delete</button>
                </form>
              </div>
            </td>
            <td class="v1">'.$item['cost'].'</td>
            <td>
              <form action="" method="post">
                <input type="number" name="quantity" min="1"
                  max="'.$item['stock'].'" value="'.$item['stock'].'">
                <button type="submit" name="update">Update</button>
              </form>
            </td>
          </tr>';
    }
    ?>
  </table>
<hr>
<a href="checkout.php">Checkout</a>
</div>
</html>
