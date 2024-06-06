<?php

require_once "../class/pre_register_class.php";
$login = new PreRegisterConfig();

if (isset($_POST["reset"])) {

    $username = $_POST["user"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpass = $_POST["confirmpass"];

    $result = $login->reset_password($password, $confirmpass, $username, $email);

    if($result == 1) {
        $_SESSION["alert"] = "Account recovered successfully";
        $_SESSION["alert_code"] = "success";
        header("Location: ../log/index.php");
        exit;
    }
    else {
        $_SESSION["alert"] = "Password does not Match";
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
    <script src="../icons/js/all.js" defer></script>

    <title>Burol Elementary School Enrollment System</title>
</head>

<body>

    <div class="container">
        <div class="forgotpass-div">
            <div class="forgotpass-form">
                <div class="forgotpass-title">
                    <h3><span class="badge text-dark">
                            <a href="forgot_password.php">
                                <i class="fa-solid fa-angle-left text-dark fa-fw me-2"></i>
                            </a>
                            Reset Password
                        </span>
                    </h3>
                </div>
                <div class="forgotpass-content">
                    <p class="text-dark">Please enter your new password.</p>
                    <form action="" method="post">
                        <input type="hidden" id="password" name="user" class="form-control" value="<?= $_SESSION["username_for_recover"]; ?>" required />
                        <input type="hidden" id="cpass" name="email" class="form-control" value="<?= $_SESSION["email_for_recover"]; ?>" required />
                        <div class="form-outline mb-4">
                            <input type="password" id="pass" name="password" class="form-control" value="" required />
                            <label class="form-label" for="password">New Password</label>
                            <div class="invalid-feedback">
                                Password must be at least 8 characters long, contain at least one uppercase, and one number.
                            </div>
                        </div>
                        <div class="form-outline">
                            <input type="password" id="cpass" name="confirmpass" class="form-control" value="" required />
                            <label class="form-label" for="cpass">Re-enter Password</label>
                        </div>
                        <input type="submit" class="btn btn-primary mt-3" name="reset" value="reset">
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="../mdb/js/mdb.min.js"></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordField = document.getElementById('pass');
            passwordField.addEventListener('input', function () {
                const password = passwordField.value;

                const regexUpperCase = /[A-Z]/;
                const regexNumber = /[0-9]/;

                if (
                password.length >= 8 &&
                regexUpperCase.test(password) &&
                regexNumber.test(password)
                ) {
                passwordField.classList.remove('is-invalid');
                } else {
                passwordField.classList.add('is-invalid');
                }
            }); 
        });
    </script>
    <?php include_once "../includes/footer.php"; ?>
</body>

</html>
