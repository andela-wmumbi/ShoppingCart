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
if (!empty($_POST)) {
    $cart = [];
    $itemId = $_POST['itemId'];
    $quantity = $_POST['quantity'];

    $sql = "SELECT id FROM item WHERE id = :itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();

    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    $cart = $_SESSION['cart'];
    if ($id && filter_var($itemId, FILTER_VALIDATE_INT)) {
        $cart[$itemId] = $quantity;
        $_SESSION['cart'] = $cart;
        redirect('index.php');
    }
        echo "Item not found";
}
?>
<div>
<?php
echo '<div class="display">
				<div class="card" style="width: 20rem;">
					<img class="card-img-top" src="./images/watch.jpg" alt="Card image cap">
					<div class="card-body">
						<h4>'.$item['name'].'</h4>
						<p>Stock: '.$item['quantity'].'</p>
						<p>Price: $'.$item['cost'].'</p>
					</div>
				</div>
      </div>';

echo '<form action="" method="post">
      <input type="hidden" name="itemId" value='.$item['id'].'>
			Qty: <input type="number" name="quantity" min="1" max="'.$item['quantity'].'" value="1">
			<br>
			<br>
      <button type="submit" name="cart">Add to cart</button>
      </form>';
?>
</div>
