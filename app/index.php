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
<head> <link rel="stylesheet" href="main.css"></head>
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
					<p>Quantity: '.$item['quantity'].'</p>
					<p>Price: $'.$item['cost'].'</p>
				</div>
			</div>
        </div>';
}
?>
</div>
</html>
