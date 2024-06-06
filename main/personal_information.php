
<?php 
require_once "../class/enrollee_class.php";

$select = new EnrolleConfig();

$student_info = $select->display_my_profile();

// AUTHENTICATION CHECK
if(!isset($_SESSION["user_ID"])) {
    header("location: ../log/index.php");
}

// Check if the user has the 'admin' role
if ($_SESSION['role'] !== 'Student') {
    // Redirect to a different page or show an error message
    header('HTTP/1.1 403 Forbidden');
    die('Forbidden - Insufficient Permissions');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../images/logo.jpg">
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../mdb/css/mdb.min.css">

    <!-- JAVASCRIPT LINKS -->
    <script src="../mdb/js/mdb.min.js" defer></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script src="../icons/js/all.js" defer></script>
    <title>Document</title>
</head>

<body>
    <header>
        <?php include "../includes/navbar.php"; ?>
    </header>
    <div class="container-fluid">
        <div class="main-section">

            <div class="columns">
                <?php include "../includes/sidebar.php"; ?>
            </div>

            <div class="columns main-section-article">
                <div class="cols-title title-show">
                    <h4><i class="fa-solid fa-user fa-fw me-2"></i>My Profile</h4>
                </div>
                <div class="cols">
                    <div class="section-title">
                        <img class="logo" src="../images/logo.jpg" alt="">
                        <h5 class="text-dark">Brgy. Burol Elementary School</h5>
                    </div>

                    <div class="cols">
                        <div class="application-details">
                            <form action="" method="post" id="enroll">
                                <div class="cols">
                                    <h5 class="pb-4">STUDENT INFORMATION</h5>
                                </div>
                                <div class="cols col-names">
                                    
                                <?php if($student_info["STATUS"] == "Enrolled"): ?>

                                    <div class="form-outline mb-4">
                                        <input type="" id="form6Example1" name="lrn" class="form-control" placeholder="LRN must be 12 numbers only" 
                                        value="<?= $student_info["LRN"]; ?>" required pattern="[0-9]{12}" disabled/>
                                        <label class="form-label" for="form6Example1">Learner Reference Number (LRN )</label>
                                    </div>

                                <?php endif; ?>

                                    <div class="form-outline">
                                        <input type="hidden"/>
                                    </div> 
                                </div>
                                <div class="cols col-names">
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form6Example1" name="lname" class="form-control" value="<?= $student_info["LASTNAME"]; ?>"  disabled/>
                                        <label class="form-label" for="form6Example1">Last Name</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form6Example3" name="fname" class="form-control" value="<?= $student_info["FIRSTNAME"]; ?>"  disabled/>
                                        <label class="form-label" for="form6Example3">First Name</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form6Example3" name="mname" class="form-control" value="<?= $student_info["MIDDLENAME"]; ?>" disabled/>
                                        <label class="form-label" for="form6Example3">Middle Name</label>
                                    </div>
                                </div>
                                <div class="cols col-names">
                                    <div class="form-outline mb-4">
                                        <label class="form-label form-check-inline" for="form6Example3">Sex</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male" disabled <?= ($student_info["SEX"] == "Male") ? "checked" : ""; ?> />
                                            <label class="form-check-label" for="inlineRadio1">Male</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female" disabled <?= ($student_info["SEX"] == "Female") ? "checked" : ""; ?> />
                                            <label class="form-check-label" for="inlineRadio2">Female</label>
                                        </div>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="number" id="age" name="age" class="form-control" value="<?= $student_info["AGE"]; ?>" disabled onKeyPress="if(this.value.length==2) return false;" />
                                        <label class="form-label" for="age">Age</label>
                                    </div>
                                </div>
                                <div class="cols second-personal-info">
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form6Example3" name="address" class="form-control" value="<?= $student_info["ADDRESS"]; ?>" disabled />
                                        <label class="form-label" for="form6Example3">Address</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form6Example3" name="pbirth" class="form-control" value="<?= $student_info["PLACE_OF_BIRTH"]; ?>" disabled />
                                        <label class="form-label" for="form6Example3">Place of Birth</label>
                                    </div>
                                    <div class="form-outline mb-4 datepicker" data-mdb-toggle="datepicker">
                                        <input type="date" class="form-control" id="exampleDatepicker1" value="<?= $student_info["BIRTH_DATE"]; ?>" data-mdb-toggle="datepicker" name="birthdate" disabled />
                                        <label for="exampleDatepicker1" class="form-label">Birthdate</label>
                                    </div>
                                    <div class="form-outline mb-4">
                                        <input type="text" id="form6Example1" name="nationality" class="form-control" value="<?= $student_info["NATIONALITY"]; ?>" disabled />
                                        <label class="form-label" for="form6Example1">Nationality</label>
                                    </div>
                                    <div class="form-outline mb-2">
                                        <input type="text" id="form6Example3" name="religion" class="form-control" value="<?= $student_info["RELIGION"]; ?>" disabled />
                                        <label class="form-label" for="form6Example3">Religion</label>
                                    </div>
                                </div>
                                <div class="row">
                                <h5 class="pb-4">PARENT INFORMATION</h5>
                                    <div class="col">
                                        
                                        <div class="form-outline mb-4">
                                            <input type="text" id="form6Example3" name="mothername" class="form-control" value="<?= $student_info["MOTHER_NAME"]; ?>" disabled/>
                                            <label class="form-label" for="form6Example3">Mother's Name</label>
                                        </div>
                                        
                                        <div class="form-outline mb-4">
                                            <input type="text" id="form6Example3" name="fathername" class="form-control" value="<?= $student_info["FATHER_NAME"]; ?>" disabled/>
                                            <label class="form-label" for="form6Example3">Father's Name</label>
                                        </div>
                                        
                                        <div class="form-outline mb-4">
                                            <input type="text" id="form6Example3" name="guardianname" class="form-control" value="<?= $student_info["GUARDIAN_NAME"]; ?>" disabled/>
                                            <label class="form-label" for="form6Example3">Guardian's Name</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="form6Example3" name="guardianname" class="form-control" value="<?= $student_info["RELATIONSHIP"]; ?>" disabled/>
                                            <label class="form-label" for="form6Example3">Relationship</label>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="form-outline mb-4">
                                            <input type="text" id="phone" name="moccupation" class="form-control" value="<?= $student_info["MOTHER_OCCUPATION"]; ?>" disabled />
                                            <label class="form-label" for="phone">Mother's Occupation</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="phone" name="foccupation" class="form-control" value="<?= $student_info["FATHER_OCCUPATION"]; ?>" disabled />
                                            <label class="form-label" for="phone">Father's Occupation</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="text" id="occu" name="guardianoccupation" class="form-control" value="<?= $student_info["GUARDIAN_OCCUPATION"]; ?>" disabled />
                                            <label class="form-label" for="occu">Guardian's Occupation</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="number" id="phone" name="contact" class="form-control" placeholder="Must be 11 numbers only" value="<?= $student_info["CONTACT_NO"]; ?>" disabled pattern="[0-9]{11}" onKeyPress="if(this.value.length==11) return false;" />
                                            <label class="form-label" for="phone">Contact No.</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Submit button -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include "../includes/footer.php"; ?>
</body>

</html>