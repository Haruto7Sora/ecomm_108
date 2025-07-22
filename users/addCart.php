<?php
    if(!isset($_SESSION)) {
        session_start();
    }

    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['addCart'])) {
        $itemID = $_GET['itemID'];
        $qty = $_GET['qty'];
        // echo "$itemID is clicked";

        if(array_key_exists('cart', $_SESSION)) {
            $cart = $_SESSION['cart']; // getting current cart value from SESSION
            
            if(!array_key_exists($itemID, $cart)) {
                $cart[$itemID] = $qty;
            } else {
                $cart[$itemID] = $qty;
            }
        } else {
            $cart = array();
            $cart[$itemID] = $qty;
        }

        $_SESSION['cart'] = $cart;
        header("Location: customerViewItem.php");
    }

    if(isset($_GET['did'])) {
        unset($_SESSION['cart'][$_GET['did']]);
        header("Location: viewCart.php");
    }
?>