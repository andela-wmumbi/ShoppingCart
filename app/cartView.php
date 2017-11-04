<?php

require "../includes/session.php";
require "../includes/db.php";

if (!empty($_POST)) {
    $cart = [];
    $itemId = $_POST['itemId'];
    $count = $_POST['count'];

    $sql = "SELECT id FROM item WHERE id = :itemId";
    $stmt = $connect->prepare($sql);
    $stmt->bindValue(':itemId', $itemId);
    $stmt->execute();

    $id = $stmt->fetch(PDO::FETCH_ASSOC);

    $cart = $_SESSION['cart'];
    if ($id && filter_var($itemId, FILTER_VALIDATE_INT)) {
        $cart[$itemId] = $count;
        $_SESSION['cart'] = $cart;
    }
    print_r($_SESSION['cart']);
}
