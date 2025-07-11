<?php
    require_once "../dbconn.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    function itemInfo($id) {
        global $conn;
        try {
            $sql = "SELECT i.item_id, i.iname, i.price, i.description, i.quantity, i.img_path, c.cname as category
                    FROM item as i, category as c
                    WHERE i.category = c.cid AND i.item_id = ?";

            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            $item = $stmt->fetch();

            return $item;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row my-5">
            <div clas="col-12 col-md-6 col-lg-3 mx-auto py-5">
                <?php
                    if(isset($_SESSION['cart'])) {
                        $cart = $_SESSION['cart'];

                        echo "<table class='table table-striped'>";

                        foreach($cart as $id => $qty) {
                            $item = itemInfo($id);
                            echo "<tr>
                                    <td>$item[iname]</td>
                                    <td>$item[price]</td>
                                    <td>$item[category]</td>
                                    <td><img style='width: 50px; height: 50px;' src=../$item[img_path]></td>
                                    <td>$qty</td>
                                </tr>";
                        }

                        echo "</table>";
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>