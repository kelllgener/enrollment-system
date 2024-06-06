<?php 

require_once "../class/subject_class.php";

$subject = new SubjectConfig();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if(!isset($_GET["UPDATE_SUBJECT_BY_ID"]) && empty($_GET["UPDATE_SUBJECT_BY_ID"])) {
        header("location: ../main/subject.php");
        exit;
    }

    $subject_id = $_GET["UPDATE_SUBJECT_BY_ID"];

    $row = $subject->select_subject_to_update($subject_id);

    // USER INFORMATION FROM DATABASE
    $subject_id = $row["SUBJECT_ID"];
    $subject_name = $row["SUBJECT_NAME"];
    $subject_code = $row["SUBJECT_CODE"];
    
}

else {
    if(isset($_POST["submit"])) {

        $subject_id = $_POST["subject_id"];
        $subject_name = $_POST["subject-name"];
        $subject_code = $_POST["subject-code"];
        $result = $subject->update_subject($subject_name, $subject_code, $subject_id);

        if ($result == 1) {
            $_SESSION["alert"] = "Subject Updated Successfully";
            $_SESSION["alert_code"] = "success";
            // Redirect the user after a successful update
            header("location: ../admin/subject.php");
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
    <title>Document</title>
</head>
<body>
    <header>    
        <?php include "../includes/navbar.php"; ?>
    </header>
    <div class="container m-auto">
        <div class="appointment-form bg-light h-100 p-5">
            <div class="update-header">
                <p class="btn" onclick="close_update_for_subject()">&times;</p>
                <h3>UPDATE SUBJECT</h3>
            </div>
            <br><br>
            <form action="" method="post" id="updateForm">
                <input type="hidden" id="subject_id" name="subject_id" class="form-control" value="<?= $subject_id ?>" required />
                <div class="form-outline mb-4">
                    <textarea class="form-control" id="form6Example7" name="subject-name" rows="4"><?= $subject_name; ?></textarea>
                    <label class="form-label" for="form6Example7">Subject Name</label>
                </div>
                <div class="form-outline mb-4">
                    <input type="text" id="subject-code" name="subject-code" class="form-control" value="<?= $subject_code; ?>"  />
                    <label class="form-label" for="subject-code">Subject Code</label>
                </div>
                <!-- Submit button -->
                <input type="submit" class="btn btn-primary btn-lg btn-block mb-4 mt-4" value="Update Now" name="submit">
            </form>
        </div>
    </div>
    <?php include "../includes/footer.php"; ?>
</body>
</html>
