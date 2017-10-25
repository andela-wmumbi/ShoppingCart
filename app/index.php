<?php
require "../includes/session.php";
require "../includes/db.php";
require "../includes/utils.php";

$sql = "SELECT * FROM item";
$stmt = $connect->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll();

?>
<?php
foreach($items as $key => $item) {
echo '<div class="card">
  <img src="" alt="Avatar">
  <div class="container">
    <h4><b>'.$item['name'].'</b></h4>
    <p>'.$item['quantity'].'</p>
    <a href="itemView.php?id='.$item['id'].'">View More</a>
  </div>
</div>';
}
?>
