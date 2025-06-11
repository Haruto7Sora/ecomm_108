<?php
    $server = "localhost"; // server name
    $user = "root"; // username
    $password = ""; // password
    $database = "rose_mall"; // database name

    $dsn = "mysql:host=$server, dbname=$database"; // 

    try {
        $conn = new PDO($dsn, $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // to show exception messages
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); // to access table row in object style
        echo "connection established";
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>