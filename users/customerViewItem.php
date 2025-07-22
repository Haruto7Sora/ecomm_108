<?php
require_once "../dbconn.php";
if (!isset($_SESSION)) {
    session_start();
}
try {
    $sql = "select * from category";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    echo $e->getMessage();
}




try {
    $sql = "select i.item_id, i.iname,
		i.price, i.description,
        i.quantity, i.img_path,
        c.cname as category
        from item i, category c 
        where i.category = c.cid";

    $stmt = $conn->query($sql);
    $items = $stmt->fetchAll();
    //print_r($items);

} catch (PDOException $e) {
    echo $e->getMessage();
}


if (isset($_GET['cate'])) {
    $cid = $_GET['cateChoose'];
    try {
        //
        $sql = "select i.item_id, i.iname,
            i.price, i.description,
            i.quantity, i.img_path,
            c.cname as category
            from item i, category c 
            where i.category = c.cid
            and  c.cid=?";

        $stmt = $conn->prepare($sql);
        $stmt->execute([$cid]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} // end if of category selection

if (isset($_GET['priceRadio'])) {
    $range = $_GET['priceRange'];
    $sql = "select i.item_id, i.iname,
            i.price, i.description,
            i.quantity, i.img_path,
            c.cname as category
            from item i, category c 
            where i.category = c.cid
            and  i.price between ? and ?";
    $lower = 0;
    $upper = 0;
    if ($range == 0) {
        $lower = 1;
        $upper = 100;
    } else if ($range == 1) {
        $lower = 101;
        $upper = 200;
    } else if ($range == 2) {
        $lower = 201;
        $upper = 300;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute([$lower, $upper]);
    $items = $stmt->fetchAll();
}
if (isset($_GET['bSearch'])) {
    $keyword =  $_GET['wSearch'];
    try {
        $sql = "select * from item where iname like ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(["%" . $keyword . "%"]);
        $items = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$_SESSION['items'] = $items;


?>
<?php if (isset($_SESSION['customerEmail']) && isset($_SESSION['clogin'])) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>View Item</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
        </style>
        <script>
            function decrease(btn) {
                const form = btn.closest("form");
                const qtyInput = form.querySelector("[name='qty']"); // form control qty text box
                let qty = parseInt(qtyInput.value) || 0;
                if (qty > 0) // if qty >0 , it will decrease
                    qty--;
                qtyInput.value = qty; // setting value to qty text box 

            }

            function increase(btn) {
                const form = btn.closest("form");
                const qtyInput = form.querySelector("[name='qty']");
                let qty = parseInt(qtyInput.value) || 0; // before increase
                if (qty < 10) // allow qtn to buy to 10
                    qty++;
                qtyInput.value = qty;
            }
        </script>



    </head>
    <!-- 

-->

    <body class="bg-success p-2 text-dark bg-opacity-50">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <?php require_once "cnavbar.php" ?>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-2 py-5">
                    <form action="viewItem.php" method="get" class="form border border-primary border-1 rounded">
                        <select name="cateChoose" class="form-select">
                            <option>Choose Category</option>
                            <?php
                            if (isset($categories)) {
                                foreach ($categories as $category) {
                                    echo "<option value=$category[cid]> $category[cname] </option>";
                                }
                            }

                            ?>

                        </select>
                        <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="cate" type="submit">Submit</button>
                    </form>
                    <form action="viewItem.php" method="get" class="mt-5 form border border-primary border-1 rounded">
                        <fieldset>
                            <legend>
                                <h6>Choose Price Range</h6>
                            </legend>

                            <div class="form-check">

                                <input class="form-check-input" type="radio" name="priceRange" value="0">
                                <label class="form-check-label" for="priceRange">
                                    $1-$100
                                </label>
                                <br>
                                <input class="form-check-input" type="radio" name="priceRange" value="1">
                                <label class="form-check-label" for="priceRange">
                                    $100-$200
                                </label>
                                <br>

                                <input class="form-check-input" type="radio" name="priceRange" value="2">
                                <label class="form-check-label" for="priceRange">
                                    $201-$300
                                </label>
                            </div>
                            <button class="mt-3 btn btn-sm btn-outline-primary rounded-pill" name="priceRadio" type="submit">Submit</button>

                        </fieldset>


                    </form>

                </div>

                <div class="col-md-10 mx-auto py-5 mb-2">
                    <?php if (array_key_exists('cart', $_SESSION)) { ?>
                        <div class="py-2 d-flex justify-content-end"> <a href="viewCart.php"><img src="profile/cart2.png" alt="view cart" style="width:60px; height:60px"></a></div>

                    <?php } ?>






                    <?php
                    if (isset($items)) {
                        echo "<div class=row>";
                        foreach ($items as $item) { ?>
                            <div class="col-md-3 mb-2">
                                <!-- card shadow-sm border-0 rounded-4 h-100   -->
                                <div class="card shadow-sm border-0 rounded-4 h-100 py-3 px-3">
                                    <img style="width:100px; height:80px;"
                                        class="card-img-top rounded-top-4 img-fluid" src="../<?php echo $item['img_path']; ?>" alt="">
                                    <div class="card-title">
                                        <?php echo $item['iname']; ?>
                                    </div>
                                    <div class="card-body">
                                        <div> $<?php echo $item['price']; ?></div>
                                        <div> <?php echo $item['category']; ?></div>

                                        <div style="height:30px;" class="mb-1"> <?php echo substr($item['description'], 0, 10); ?></div>
                                        <div>
                                            <a href="" class="btn btn-outline-primary rounded-pill">View Detail</a>

                                            <form action="addCart.php" method="get">
                                                <button type="button" onclick="decrease(this)">-</button>
                                                <input type="hidden" name="itemID" value="<?php echo $item['item_id']; ?>">
                                                <input type="text" min="0" max="10" size="1" id="qty" name="qty"
                                                    value="<?php if (isset($_SESSION['cart'][$item['item_id']]))
                                                                echo $_SESSION['cart'][$item['item_id']];

                                                            else echo "1"; ?>">
                                                <button type="button" onclick="increase(this)">+</button>

                                                <button type="submit" class="btn btn-outline-primary rounded-pill" name="addCart">Add to cart</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                            </div>


                    <?php }

                        echo "</div>";
                    }

                    ?>

                </div>

            </div>
        </div>
    </body>

    </html>
<?php } else {
    header("Location:clogin.php");
} ?>