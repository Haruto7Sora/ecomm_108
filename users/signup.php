<?php
    require_once "../dbconn.php";

    if(!isset($_SESSION)) {
        session_start();
    }

    $cities = array("Yangon", "Mandalay", "Magway", "Myitkyina", "Mawlamyine");

    if(isset($_POST['signUp'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $city = $_POST['city'];
        $profile = $_FILES['profile'];
        $filepath = "profile/".$_FILES['profile']['name'];

        // Verifying password with confirm password
        if($password === $cpassword) {
            if(strlen($password) >= 8) {
                if(isPasswordStrong($password)) {
                    try {
                        $hashPassword = password_hash($password, PASSWORD_BCRYPT);
                        $status = move_uploaded_file($_FILES['profile']['tmp_name'], $filepath);
                        
                        if($status) {
                            $sql = "INSERT INTO users VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
                            $stmt = $conn->prepare($sql);
                            $stmt->execute([null, $username, $email, $gender, $city, $phone, $filepath, $hashPassword]);

                            $_SESSION['customerEmail'] = $email;
                            $_SESSION['customerSignupSuccess'] = "Signup Success! You can login here!";

                            header("Location: clogin.php");
                        }
                    } catch (PDOException $e) {
                        echo $e->getMessage();
                    }
                } else {
                    $errMessage = "Password must include at least one uppercase letter, one digit and one special character!";
                }
            } else {
                $errMessage = "Password length must be at least 8!";
            }
        } else {
            $errMessgae = "Password and confirm password must be the same!";
        }
    }

    function isPasswordStrong($password) {
        $digitCount = 0;
        $capitalCount = 0;
        $specCount = 0;

        for($i = 0; $i < strlen($password); $i++) {
            // Confirming digit or not
            if(ctype_digit($password[$i])) {
                $digitCount ++;
            } else if(ctype_upper($password[$i])) {
                $capitalCount ++;
            } else if(preg_match('/[^a-zA-Z0-9\s]/', $password[$i])) {
                $specCount ++;
            }
        }

        if($digitCount >=1 && $capitalCount >=1 && $specCount >= 1) {
            return true;
        } else {
            return false;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sign Up</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    </head>
    <body class="bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 mx-auto py-3 px-4 my-5 border border-3">
                    <h2 class="text-center mb-5">Sign Up</h2>
                    <form action="signup.php" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="username" class="form-label fw-bold">Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold">Password</label>
                            <input type="password" name="password" class="form-control mb-3" required>

                            <?php
                                if(isset($errMessage)) {
                                    echo "<p class='alert alert-danger'>$errMessage</p>";
                                }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="cpassword" class="form-label fw-bold">Confirm Password</label>
                            <input type="password" name="cpassword" class="form-control" required>
                        </div>

                        <div>
                            <p class="text fw-bold">Gender</p>
                            <div class="mb-3">
                                <input class="form-check-input" type="radio" name="gender" value="Male" required>
                                <label class="form-check-label" for="gender">Male</label>
                            </div>

                            <div class="mb-3">
                                <input class="form-check-input" type="radio" name="gender" value="Female" required>
                                <label class="form-check-label" for="gender">Female</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Phone Number</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <p class="fw-bold">City</p>
                            <select name="city" class="form-select" required>
                                <option value="" class="fw-bold">Choose City</option>
                                <?php
                                    if(isset($cities)) {
                                        foreach($cities as $city) {
                                            echo "<option value=$city>$city</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="profile" class="form-label fw-bold">Choose Profile Image</label>
                            <input type="file" name="profile" class="form-control" required>
                        </div>

                        <div class="mb-1">
                            <button type="submit" name="signUp" class="btn btn-primary mt-3">Sign up</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>