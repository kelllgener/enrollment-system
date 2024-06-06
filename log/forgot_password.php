<?php
require_once "../class/pre_register_class.php";
$login = new PreRegisterConfig();

$username = $email = "";

if (isset($_POST["search"])) {

    $username = $_POST["username"];
    $email = $_POST["email"];

    $result = $login->searchforForgotAccount($username, $email);

    if($result == 1) {
        $_SESSION["alert"] = "Account Found";
        $_SESSION["alert_code"] = "success";
    }
    else {
        $_SESSION["alert"] = "Account cannot be Found";
        $_SESSION["alert_code"] = "error";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="../images/logo.jpg">

    <link rel="stylesheet" href="../mdb/css/mdb.min.css">
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../icons/css/all.min.css">
    <link rel="stylesheet" href="../CSS/style.css">

    <!-- JAVASCRIPT LINKS -->
    <script src="../mdb/js/mdb.min.js" defer></script>
    <script src="../icons/js/all.js" defer></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <title>Burol Elementary School Enrollment System</title>

</head>

<body>

    <div class="container">
        <div class="forgotpass-div">
            <div class="forgotpass-form">
                <div class="forgotpass-title">
                    <h3><span class="badge text-dark"><a href="index.php"><i class="fa-solid fa-angle-left text-dark fa-fw me-2"></i></a>Find your account</span></h3>
                </div>
                <div class="forgotpass-content">
                    <p class="text-dark">Please enter your email and LRN number to search for you account.</p>
                    <form action="" method="post">
                        <div class="form-outline mb-4">
                            <input type="text" id="username" name="username" class="form-control" value="<?php echo $username; ?>" required />
                            <label class="form-label" for="email">Username</label>
                        </div>
                        <div class="form-outline">
                            <input type="email" id="email" name="email" class="form-control" placeholder="example@gmail.com" value="<?php echo $email; ?>" required />
                            <label class="form-label" for="email">Email</label>
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" name="search" value="search">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "../includes/footer.php"; ?>

</body>

</html>
