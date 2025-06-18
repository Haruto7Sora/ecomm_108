<?php
    $server = "localhost"; // server name
    $user = "root"; // username
    $password = ""; // password
    $database ="rose_mall"; // database name
    $dsn = "mysql:host=$server; dbname=$database"; // creating a DSN (Data Source Name) to connect to the database
    try{
        // connect database using connection string, username, password
        // PDO - PHP Data Object
        $conn = new PDO($dsn, $user, $password);

        // to show exception messages
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // to accesss table row
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // echo "connection established";

    }catch(PDOException $e)
    {
        echo $e->getMessage();
    }
?>