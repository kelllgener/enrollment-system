<?php

require_once "../class/user_account_class.php";

$useracc = new UserAccount();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if (!isset($_GET["UPDATE_BY_ID"]) && !empty($_GET["UPDATE_BY_ID"])) {
        header("location: ../admin/user_account.php");
        exit;
    }

    $userID = $_GET["UPDATE_BY_ID"];

    $row = $useracc->selectUserToUpdate($userID);

    // USER INFORMATION FROM DATABASE
    $old_profile = $row["PROFILE"];
    $firstname = $row["FIRSTNAME"];
    $lastname = $row["LASTNAME"];
    $username = $row["USERNAME"];
    $email = $row["EMAIL"];
    $password = $row["PASSWORD"];
    $role = $row["ROLE"];
} else {
    if (isset($_POST["save"])) {

        $profile = $_FILES['profile']['name'];

        $userID = $_POST["UserID"];
        $firstname = $_POST["fname"];
        $lastname = $_POST["lname"];
        $username = $_POST["uname"];
        $email = $_POST["email"];
        $role = $_POST["role"];

        $result = $useracc->updateUser($userID, $firstname, $lastname, $username, $email, $profile);

        if ($result == 1) {
            $_SESSION["alert"] = "Account Updated Successfully";
            $_SESSION["alert_code"] = "success";
            // Redirect the user after a successful update
            header("location: ../admin/user_account.php");
            exit;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/update.css">
    <link rel="stylesheet" href="../icons/css/all.min.css">
    <link rel="stylesheet" href="../fonts/fonts.css">

    <!-- JAVASCRIPT -->
    <script src="../icons/js/all.js" defer></script>
    <script src="../mdb/js/mdb.min.js" defer></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script src="../js/index.js" defer></script>
    <title></title>
</head>

<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>
    <div class="container m-auto">
        <div class="appointment-form bg-light h-100 p-5">
            <div class="update-header">
                <p class="btn" onclick="close_update_for_user()">&times;</p>
                <h3>UPDATE ACCOUNT</h3>
            </div>
            <br><br>
            <form action="" method="post" enctype="multipart/form-data">
                <div class=" text-center">
                    <label for="profile_img" class="profile_label">
                        <img class="shadow-4-strong profile-img" src="<?php echo "../profiles/" . $old_profile; ?>" alt="">
                    </label>
                    <input type="file" class="profile_img" name="profile" id="profile_img" accept="image/*" />
                </div>
                <div class="row m-3">
                    <input type="hidden" id="userid" name="UserID" class="form-control" value="<?php echo $userID ?>" required />
                    <div class="col p-0">
                        <div class="form-outline mb-4">
                            <input type="text" id="form6Example1" name="fname" class="form-control" value="<?php echo $firstname; ?>" required />
                            <label class="form-label" f or="form6Example1">First Name</label>
                        </div>
                    </div>
                    <div class="col p-0">
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form6Example2" name="lname" class="form-control" value="<?php echo $lastname; ?>" required />
                            <label class="form-label" for="form6Example2">Last Name</label>
                        </div>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="username" name="uname" class="form-control" value="<?php echo $username; ?>" required />
                        <label class="form-label" for="username">Username</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="email" id="form6Example3" name="email" class="form-control" value="<?php echo $email; ?>" required />
                        <label class="form-label" for="form6Example3">Email</label>
                    </div>
                    <!-- Text input -->

                    <select name="role" id="" class="form-select" <?php echo $role == "Student" ? "disabled" : ""; ?>>

                        <option value="1" <?php echo $role == "Administrator" ? "selected" : ""; ?>>Administrator</option>
                        <option value="2" <?php echo $role == "Teacher" ? "selected" : ""; ?>>Teacher</option>
                        <option value="3" <?php echo $role == "Student" ? "selected" : ""; ?> disabled>Student</option>

                    </select>
                    <!-- Submit button -->
                    <input type="submit" class="btn btn-primary btn-lg btn-block mb-4 mt-4" value="Update Now" name="save">
                </div>
            </form>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>
</body>

</html>