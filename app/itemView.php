<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$itemId = $_GET['id'];

if (filter_var($itemId, FILTER_VALIDATE_INT)) {
    $sql = "SELECT * FROM item WHERE id=:itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();

    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<div>
<?php
echo '<h4>'.$item['name'].'</h4>
      <p>'.$item['quantity'].'</p>
      <p>'.$item['cost'].'</p>';

echo '<form action="cartView.php" method="post">
      <input type="hidden" name="itemId" value='.$item['id'].'>
      <input type="number" name="count" min="1" max="5"><br/>
      <button type="submit" name="cart">Add to cart</button>
      </form>';
?>
</div>
