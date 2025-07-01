<?php
    require_once "dbconn.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    // checking whether login button is clicked
    if(isset($_POST['adminLogin'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        try {
            $sql = 'SELECT username, password FROM admin WHERE username=?';
            $stmt = $conn->prepare($sql);
            $stmt->execute([$username]);
            $userInfo = $stmt->fetch();

            if(!$userInfo) {
                $message = "Username or password might be incorrect!";
            } else {
                if(password_verify($password, $userInfo["password"])) {
                    $_SESSION['adminId'] = $username;
                    $_SESSION['login'] = true;
                    header("Location: viewItem.php");
                } else {
                    $message = "Username and password might be incorrect!";
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <?php require_once "navbar.php" ?>
        </div>

        <div class="row">
            <div class="col-md-4 mx-auto py-5">
                <form class="form bg-light" method="post" action="login.php">
                    <fieldset class="border border-1 py-3 px-3">
                        <legend>Login Here</legend>

                        <?php
                            if(isset($message)) {
                                echo "<p class='alert alert-danger'>$message</p>";
                            }
                        ?>

                        <div class="mb-2">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username">
                        </div>

                        <div class="mb-2">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary rounded-pill mt-3" name="adminLogin">Login</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>

</html>