<?php

require "../includes/session.php";

var_dump($_POST);
if(!empty($_POST)) {
  $cart = $_POST['itemId'];
  $_SESSION['itemId'] = $cart;

  print_r($_SESSION['itemId']);
}
?>
