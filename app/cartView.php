<?php

require "../includes/session.php";

if(!empty($_POST)) {
  $cart = [];
  $id = $_POST['itemId'];

  $cart = $_SESSION['cart'];
  if(!in_array($id, $cart)) {
    $cart[] = $id;
    $_SESSION['cart'] = $cart;
  }
  print_r($_SESSION['cart']);
}
?>
