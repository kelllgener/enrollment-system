<?php

require_once "../class/user_account_class.php";
$useracc = new UserAccount();

$user_id = $_SESSION["user_ID"];

if (isset($_POST["upload"])) {

    $profilepic = $_FILES['profile']['name'];

    $location = "../profiles/";
    $sql = "UPDATE tbl_users SET PROFILE = '$profilepic' where USER_ID = '$user_id'";
    $result = $useracc->getConnection()->query($sql);
    if ($result) {

        move_uploaded_file($_FILES['profile']['tmp_name'], $location . $profilepic);
        $_SESSION["alert"] = "Profile Updated Successfully";
        $_SESSION["alert_code"] = "success";
        
    } else {
        die("Invalid Query: " . $useracc->getConnection()->connect_error);
    }
    
}

if(isset($_POST["saveupdate"])) {

    $newpassword = $_POST["newpass"];
    $currentpass = $_POST["currentpass"];
    $reenterpass = $_POST["reenter"];

    $result = $useracc->update_user_passwords($currentpass, $newpassword, $reenterpass);

    if($result == 1) {
        $_SESSION["alert"] = "Password Updated Successfully";
        $_SESSION["alert_code"] = "success";
    }
    elseif ($result == 2) {
        $_SESSION["alert"] = "Password does not match";
        $_SESSION["alert_code"] = "error";
    }
    else {
        $_SESSION["alert"] = "Current Password Incorrect";
        $_SESSION["alert_code"] = "error";

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/edit_profile.css">
    <link rel="stylesheet" href="../mdb/css/mdb.min.css">
    <script src="../js/index.js" defer></script>

    <title>Document</title>
</head>

<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>
    <div class="container-fluid">
        <div class="column  main-edit">
            <div class="edit-column">
                <?php include "../includes/sidebar.php"; ?>
            </div>
            <div class="dashboard-column main-container">
                <div class="cols-title title-show">
                    <h4><i class="fa-solid fa-circle-user fa-fw me-2"></i></i>Profile</h4>
                </div>
                <div class="edit-account-head">
                    <h5>User Information</h5>
                </div>
                <div class="edit-account">

                    <div class="email-profile-section">
                        <div class="account-details">
                            <p><i class="fa-solid fa-envelope fa-fw me-2"></i>E-mail: <?= $_SESSION["email"]; ?></p>
                            <p><i class="fa-solid fa-user fa-fw me-2"></i>Username: <?= $_SESSION["username"]; ?></p>
                        </div>
                        <div class="email-image-section">
                            <img src="<?php $useracc->displayProfile(); ?>" class="shadow-4-strong" alt="">
                            <form action="" method="post" enctype="multipart/form-data" class="form-image mt-4">
                                <div class="input-group mb-2">
                                    <input type="file" class="form-control" name="profile" id="inputGroupFile04" accept="image/*" aria-describedby="inputGroupFileAddon04" required />
                                </div>
                                <div class="form-image-button">
                                    <input type="submit" class="btn btn-primary" value="Update" name="upload">
                                </div>
                            </form> 
                        </div>
                    </div>
                    
                    <div class="password-section">
                    <form action="" method="post">
                        <div class="form-outline input-group mb-4">
                            <input type="password" id="currentpass" name="currentpass" class="form-control" required/>
                            <label class="form-label" for="currentpass">Current Password</label>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" onclick="showcurrpass()" value="" aria-label="Checkbox for following text input" />
                            </div>
                        </div>
                        <div class="form-outline input-group mb-4">
                            <input type="password" id="newpass" name="newpass" class="form-control" required/>
                            <label class="form-label" for="newpass">New Password</label>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" onclick="shownewpass()" value="" aria-label="Checkbox for following text input" />
                            </div>
                        </div>
                        <div class="form-outline input-group mb-4">
                            <input type="password" id="reenter" name="reenter" class="form-control" required/>
                            <label class="form-label" for="reenter">Re-enter New Password</label>
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" onclick="showreenterpass()" value="" aria-label="Checkbox for following text input" />
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Save Changes" name="saveupdate">
                    </form>
                </div>
                </div>
                
            </div>
        </div>
    </div>
    </div>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script src="../mdb/js/mdb.min.js"></script>
    <?php include_once "../includes/footer.php"; ?>
</body>

</html>
