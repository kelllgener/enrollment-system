<?php

require_once "./class/pre_register_class.php";
$login = new PreRegisterConfig();

$username = "";

if (isset($_POST["login"])) {
    $username = $_POST["uname"];
    $password = $_POST["pass"];

    // Sanitize and validate the input
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    // You should use secure methods to hash and store passwords in your database
    // For example, password_hash() and password_verify()

    $result = $login->userLogin($username, $password);

    if ($result == 1) {
        $_SESSION["alert"] = "Login Successful!";
        $_SESSION["alert_code"] = "success";
        header("location: ../admin/dashboard.php");
        exit();
    } elseif ($result == 2) {
        $_SESSION["alert"] = "Login Failed! Incorrect Password.";
        $_SESSION["alert_code"] = "error";
    } elseif ($result == 3) {
        $_SESSION["alert"] = "Login Failed! Account not found!";
        $_SESSION["alert_code"] = "error";
    }

    if (isset($_POST["rem"])) {
        // Set cookies for "Remember Me" feature (not recommended for passwords)
        setcookie("Username", $username, time() + 60 * 60 * 7);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.jpg">
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./CSS/style.css">
    <link rel="stylesheet" href="./mdb/css/mdb.min.css">
    <link rel="stylesheet" href="./icons/css/all.min.css">
    <link rel="stylesheet" href="./fonts/fonts.css">

    <!-- JAVASCRIPT LINKS -->
    <script src="./mdb/js/mdb.min.js" defer></script>
    <script src="./icons/js/all.js" defer></script>
    <script src="./sweetalert/sweetalert2.all.js"></script>
    <title>Burol Elementary School Enrollment System</title>


</head>
<body>

    <header>
        <div class="container-fluid container-nav">
            <div class="site-title">
                <img src="./images/logo.jpg" alt="" />
                <h1>Burol Elementary School Enrollment System</h1>
            </div>
            <nav>
                <!-- Button trigger modal -->
                <button class="btn-login" data-mdb-toggle="modal" data-mdb-target="#exampleModal">LOGIN</button>
            </nav>
        </div>

    </header>
        <!-- Modal -->
        <form action="" method="post" class="login-form">
            <div class="modal fade text-white " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content login-content">
                        <div class="modal-header bg-none">
                            <h5 class="modal-title text-white" id="exampleModalLabel">
                                <img class="logo" src="../images/logo.jpg" alt="">&nbsp;&nbsp;Burol Elementary School
                            </h5>
                            <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body mt-4">
                            <div class="form-row">
                                <div class="form-outline mb-4">
                                    <input type="text" id="form6Example1" name="uname" class="form-control" required />
                                    <label class="form-label" for="form6Example1">Username</label>
                                </div>
                                <!-- Text input -->
                                <div class="form-outline mb-4">
                                    <input type="password" id="form6Example3" name="pass" class="form-control" required />
                                    <label class="form-label" for="form6Example3">Password</label>
                                </div>
                                <div class="forgot-pass mb-3">
                                    <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" name="rem" id="form2Example31" />
                                    <label class="form-check-label remember" for="form2Example31"> Remember me </label>
                                </div>
                                <a href="forgot_password.php" name="signup">
                                    <i class="fa-solid fa-unlock-keyhole fa-fw me-2"></i>Forgot Password
                                </a>
                                
                                </div>
                                <p>
                                    <a class="no-account text-secondary" href="index.php?enroll" name="signup">
                                        No Account Yet? <span>Enroll to Register</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <div class="modal-footer ">
                            <input type="submit" class="btn btn-success" value="Log in" name="login">
                        </div>
                    </div>
                </div>
            </div>
        </form>


    <div class="container container-login">
        <div class="columns login-image-container">
            <div class="cols hover-zoom bg-image">
                <img src="./images/bg.png" alt="" class="login-image">
            </div>
        </div>

        <div class="columns login-function-container">
            <div class="cols navigation-button-login">
                    <li><a href="index.php?home" class="">Home</a></li>
                    <li><a href="index.php?enroll" class="">Enroll Now!</a></li>
            </div>
            <div class="cols">
                <span class="contact-info">
                    <h6>Contacts: </h6>
                    <p>Email: 
                        <a class="" href="mailto:109843@deped.gov.ph">
                        <i class="fa-solid fa-envelope fa-fw me-2"></i>109843@deped.gov.ph
                        </a>
                    </p>
                    <p>Facebook: 
                        <a class="" target="_blank" href="https://www.facebook.com/profile.php?id=100064323362209">
                            <i class="fa-brands fa-facebook fa-fw me-2"></i>Burol Elementary School
                        </a>
                    </p>
                    <p>Phone no.: <i class="fa-solid fa-phone-volume fa-fw me-2"></i>049 544 9363</p>
                </span>
            </div>

            <div class="columns content-section">

                <?php (isset($_GET["enroll"])) ? include "./log/enroll.php" : include "./log/home.php"; ?>

            </div>
            
        </div>
        
    </div>
    <?php include "./includes/footer.php"; ?>
    
</body>
</html>