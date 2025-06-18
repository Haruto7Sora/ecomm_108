<?php
    require_once "dbconn.php";
    if(!isset($_SESSION)) {
        session_start();
    }
    try {
        $sql = "SELECT i.item_id, i.iname, i.price, i.description, i.quantity, i.img_path, c.cname as category
                FROM item i, category c
                WHERE i.category = c.cid";

        $stmt = $conn->query($sql);
        $items = $stmt->fetchAll();
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Items</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </head>
    <body class="bg-light">
        <!-- Navigation Bar -->
        <div class="container-fluid">
            <!-- md cannot be greater than 12 -->
            <div class="row">
                <div class="col-md-12">
                    <?php require_once "navbar.php" ?>
                </div>
            </div>
        </div>

        <!--  -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2">

                </div>
                <div class="col-md-10">
                    <?php
                        if(isset($_SESSION["insertSuccess"])) {
                            echo "<p class='alert alert-success'>$_SESSION[insertSuccess]</p>";
                            unset($_SESSION["insertSuccess"]);
                        }

                    ?>

                    <table class="table table-striped">
                        <!-- table head -->
                        <thead>
                            <!-- table row -->
                            <tr>
                                <!-- table column -->
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Category</th>
                                <th>Image</th>
                            </tr> 
                        </thead>

                        <!-- table body -->
                        <tbody>
                            <tr>
                                <?php 
                                    if(isset($items)) {
                                        foreach($items as $item) {
                                            echo "<tr>
                                                    <td>$item[iname]</td>
                                                    <td>$item[price]</td>
                                                    <td>$item[description]</td>
                                                    <td>$item[quantity]</td>
                                                    <td>$item[category]</td>
                                                    <td><img src=$item[img_path] style=width:80px; height:80px;></td>
                                                </tr>";
                                        }
                                    }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>