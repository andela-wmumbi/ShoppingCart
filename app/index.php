<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

/**
 * Retrieve all products from DB
 * Display the retrieved items
 */
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
<?php include_once "./header.html"?>
</div>
<div class="display">
<?php
$message = "";
foreach ($items as $key => $item) {
    if ($item['stock'] == 0) {
        $message = "Out of stock";
    }
    echo '<div class="display">
            <div class="card" style="width: 20rem;">
              <a href="itemView.php?id='.$item['id'].'">
                <img class="card-img-top" src="./images/watch.jpg"
                  alt="Card image cap">
              </a>
              <div class="card-body">
                <h4>'.$item['name'].'</h4>
                <p>Stock: '.$item['stock'].''." ".$message.'</p>
                <p>Price: $'.$item['cost'].'</p>
              </div>
            </div>
          </div>';
}
?>
</div>
</html>
