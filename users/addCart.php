<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['itemID'])) {
        $itemID = $_GET['itemID'];
        // echo "$itemID is clicked";

        if(array_key_exists('cart', $_SESSION)) {
            $cart = $_SESSION['cart']; // getting current cart value from SESSION
            if(!array_key_exists($itemID, $cart)) {
                $cart[$itemID] = 1;
            }
        } else {
            $cart = array();
            $cart[$itemID] = 1; // 1 is quantity value
        }

        $_SESSION['cart'] = $cart;
        header("Location: customerViewItem.php");
    }
?>