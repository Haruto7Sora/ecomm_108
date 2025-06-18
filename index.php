<?php
    require_once "dbconn.php";
    $sql = "SELECT * FROM item"; // SQL statement
    $stmt = $conn->query($sql); // Write SQL statement into database
    $stmt->execute(); // Execute SQL statement
    $items = $stmt->fetchAll(); // Extract all rows returned by query

    foreach ($items as $item) {
        // echo $item ['iname']."<br>";
        // echo $item ['price']."<br>";
        // echo $item ['description']."<br>";
        // echo $item ['quantity']."<br>";

        // echo $item ['img_path'];
        // echo "<img src=$item -> img_path>";

        echo $item['iname'];
        echo $item['price'];
        echo "<img src=$item[img_path]>";
    }
?>