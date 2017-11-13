<?php

require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$sql = "SELECT * FROM item";
$stmt = $connect->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll();

?>
<html>
<head>
	<link rel="stylesheet" href="main.css">
	<link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<div>
<?php
foreach ($items as $key => $item) {
    echo '<div class="display">
			<div class="card" style="width: 20rem;">
				<a href="itemView.php?id='.$item['id'].'">
					<img class="card-img-top" src="./images/watch.jpg" alt="Card image cap">
				</a>
				<div class="card-body">
					<h4>'.$item['name'].'</h4>
					<p>Stock: '.$item['quantity'].'</p>
					<p>Price: $'.$item['cost'].'</p>
				</div>
			</div>
        </div>';
}
?>
 <a href="cartView.php" class="btn btn-info btn-lg">
    <span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart
</a>
</div>
</html>
