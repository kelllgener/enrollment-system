<?php
require_once "../class/pre_register_class.php";
$reg = new PreRegisterConfig();

$lastname = $firstname = $middlename = $address = $sex = $birth_date = $place_of_birth = $age = $nationality = $religion = "";
$mother_name = $mother_occupation = "";
$father_name = $father_occupation = "";
$guardian_name = $contact_no = $relationship_id = $guardian_occupation = "";
$username = $email = $password = $confirm_password = "";

if (isset($_POST["enroll"])) {

    $lastname = $_POST["lname"];
    $firstname = $_POST["fname"];
    $middlename = $_POST["mname"];
    $address = $_POST["address"];
    $sex = $_POST["sex"];
    $birth_date = $_POST["birthdate"];
    $place_of_birth = $_POST["pbirth"];
    $age = $_POST["age"];
    $nationality = $_POST["nationality"];
    $religion = $_POST["religion"];
    
    $birth_cert = $_FILES['birth_cert']['name'];

    $mother_name = $_POST["mothername"];
    $mother_occupation = $_POST["moccupation"];

    $father_name = $_POST["fathername"];
    $father_occupation = $_POST["foccupation"];

    $guardian_name = $_POST["guardianname"];
    $relationship_id = $_POST["relationship"];
    $contact_no = $_POST["contact"];
    $guardian_occupation = $_POST["guardianoccupation"];

    $username = $_POST["uname"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $confirm_password = $_POST["cpass"];




    $result = $reg->insertStudent($lastname, $firstname, $middlename, $address, $sex, $birth_date, $place_of_birth, $age, $nationality, $religion, 
        $username, $email, $password, 
        $father_name, $father_occupation, 
        $mother_name, $mother_occupation, 
        $guardian_name, $relationship_id, $guardian_occupation, $contact_no,
        $confirm_password,
        $birth_cert);

    if ($result == 1) {
        $_SESSION["alert"] = "Username or Email Unavailable";
        $_SESSION["alert_code"] = "error";
    } 
    elseif ($result == 2) {
        $_SESSION["alert"] = "Registered Successfully";
        $_SESSION["alert_code"] = "success";
    } 
    elseif ($result == 3) {
        $_SESSION["alert"] = "Please Input a Valid Lastname";
        $_SESSION["alert_code"] = "error";
    } 
    elseif ($result == 4) {
        $_SESSION["alert"] = "Please Input a Valid Firstname";
        $_SESSION["alert_code"] = "error";
    } 
    elseif ($result == 5) {
        $_SESSION["alert"] = "Please Input a Valid Middlename";
        $_SESSION["alert_code"] = "error";
    } 
    elseif ($result == 6) {
        $_SESSION["alert"] = "Please Input a Valid Age";
        $_SESSION["alert_code"] = "error";
    }
    elseif ($result == 7) {
        $_SESSION["alert"] = "Please Input a Valid Nationality";
        $_SESSION["alert_code"] = "error";
    }
    elseif ($result == 8) {
        $_SESSION["alert"] = "Please Input a Valid Religion";
        $_SESSION["alert_code"] = "error";
    } 
    elseif ($result == 9) {
        $_SESSION["alert"] = "Please Input a Valid Mother name";
        $_SESSION["alert_code"] = "error";
    } 
    elseif ($result == 10) {
        $_SESSION["alert"] = "Please Input a Valid Father name";
        $_SESSION["alert_code"] = "error";
    } 

    elseif ($result == 11) {
        $_SESSION["alert"] = "Please Input a Valid Contact number";
        $_SESSION["alert_code"] = "error";
    }
    elseif ($result == 12) {
        $_SESSION["alert"] = "Please Input a Valid Email";
        $_SESSION["alert_code"] = "error";
    }
    elseif ($result == 13) {
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
    <link rel="stylesheet" href="../fonts/fonts.css">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../mdb/css/mdb.min.css">

    <!-- JAVASCRIPT LINKS -->
    <script src="../mdb/js/mdb.min.js" defer></script>
    <script src="../sweetalert/sweetalert2.all.js"></script>
    <script src="../icons/js/all.js" defer></script>

    <script defer>
        // JavaScript code to scroll to the "enroll" section on page load
        window.addEventListener('DOMContentLoaded', (event) => {
            const targetSection = document.querySelector('#enroll');
            
            // Scroll to the "enroll" section smoothly
            if (targetSection) {
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    </script>

    <title>Login</title>
</head>

<body>

    <div class="cols">
        <div class="enrollment-form">
            <h3 id="enroll">PRE REGISTRATION FORM</h3>
            <form action="" method="post"  enctype="multipart/form-data">
                <div class="cols">
                    <h5 class="pb-4">STUDENT INFORMATION</h5>
                </div>
                <div class="cols col-names">
                    <div class="form-outline mb-4">
                        <input type="text" id="textInput" name="lname" class="form-control" value="<?= $lastname ?>" required />
                        <label class="form-label" for="form6Example1">Last Name</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="textInput" name="fname" class="form-control" value="<?= $firstname ?>" required />
                        <label class="form-label" for="form6Example3">First Name</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="textInput" name="mname" class="form-control" value="<?= $middlename ?>" />
                        <label class="form-label" for="form6Example3">Middle Name</label>
                    </div>
                </div>
                <div class="cols col-names">
                    <div class="form-outline mb-4">
                        <label class="form-label form-check-inline" for="form6Example3">Sex</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="inlineRadio1" value="Male" required
                            <?= ($sex == "Male") ? "checked" : ""; ?> />
                            <label class="form-check-label" for="inlineRadio1">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="sex" id="inlineRadio2" value="Female" required 
                            <?= ($sex == "Female") ? "checked" : ""; ?>/>
                            <label class="form-check-label" for="inlineRadio2">Female</label>
                        </div>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="number" id="age" name="age" class="form-control" value="<?= $age ?>" required onKeyPress="if(this.value.length==2) return false;" />
                        <label class="form-label" for="age">Age</label>
                    </div>
                </div>
                <div class="cols second-personal-info">
                    <div class="form-outline mb-4">
                        <input type="text" id="form6Example3" name="address" class="form-control" value="<?= $address ?>" required />
                        <label class="form-label" for="form6Example3">Address</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="form6Example3" name="pbirth" class="form-control" value="<?= $place_of_birth ?>" required />
                        <label class="form-label" for="form6Example3">Place of Birth</label>
                    </div>
                    <div class="form-outline mb-4 datepicker" data-mdb-toggle="datepicker">
                        <input type="date" class="form-control" id="exampleDatepicker1" value="<?= $birth_date ?>" data-mdb-toggle="datepicker" name="birthdate" required />
                        <label for="exampleDatepicker1" class="form-label">Birthdate</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="textInput" name="nationality" class="form-control" value="<?= $nationality ?>" required />
                        <label class="form-label" for="form6Example1">Nationality</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" id="textInput" name="religion" class="form-control" value="<?= $religion ?>" required />
                        <label class="form-label" for="form6Example3">Religion</label>
                    </div>
                    <div class=" mb-4">
                        <label for="birth_cert" class="form-label text-black">Birth Certificate</label>
                        <input type="file" class="form-control" name="birth_cert" id="birth_cert" accept="image/*" data-browse="Upload Birth Cert" aria-describedby="inputGroupFileAddon04" required data-browse="Upload Birth Certificate" />
                    </div>


                </div>
                <div class="row">
                    <div class="col">
                        <h5 class="pb-4">PARENT INFORMATION</h5>
                        <div class="form-outline mb-4">
                            <input type="text" id="textInput" name="mothername" class="form-control" value="<?= $mother_name ?>" />
                            <label class="form-label" for="form6Example3">Mother's Name</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="phone" name="moccupation" class="form-control" value="<?= $mother_occupation ?>" required />
                            <label class="form-label" for="phone">Occupation</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="textInput" name="fathername" class="form-control" value="<?= $father_name ?>" />
                            <label class="form-label" for="form6Example3">Father's Name</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="phone" name="foccupation" class="form-control" value="<?= $father_occupation ?>" required />
                            <label class="form-label" for="phone">Occupation</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" id="textInput" name="guardianname" class="form-control" value="<?= $guardian_name ?>" />
                            <label class="form-label" for="form6Example3">Guardian's Name</label>
                        </div>
                        <select class="form-select mb-4" name="relationship" id="relationship" required>
                            <option value="" selected>Relationship</option>

                            <option value="501" <?php echo $relationship_id == 501 ? "selected" : ""; ?>>Father</option>
                            <option value="502" <?php echo $relationship_id == 502 ? "selected" : ""; ?>>Mother</option>
                            <option value="503" <?php echo $relationship_id == 503 ? "selected" : ""; ?>>Grandfather</option>
                            <option value="504" <?php echo $relationship_id == 504 ? "selected" : ""; ?>>Grandmother</option>
                            <option value="505" <?php echo $relationship_id == 505 ? "selected" : ""; ?>>Uncle</option>
                            <option value="506" <?php echo $relationship_id == 506 ? "selected" : ""; ?>>Aunt</option>
                            <option value="507" <?php echo $relationship_id == 507 ? "selected" : ""; ?>>Brother</option>
                            <option value="508" <?php echo $relationship_id == 508 ? "selected" : ""; ?>>Sister</option>
                            <option value="509" <?php echo $relationship_id == 509 ? "selected" : ""; ?>>Cousin</option>

                        </select>
                        <div class="form-outline mb-4">
                            <input type="text" id="occu" name="guardianoccupation" class="form-control" value="<?= $guardian_occupation ?>" required />
                            <label class="form-label" for="occu">Occupation</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="number" id="phone" name="contact" class="form-control" placeholder="Must be 11 numbers only" value="<?= $contact_no ?>" required pattern="[0-9]{11}" onKeyPress="if(this.value.length==11) return false;" />
                            <label class="form-label" for="phone">Contact No.</label>
                        </div>
                    </div>
                    <div class="col">
                        <h5 class="pb-4">ACCOUNT INFORMATION</h5>
                        <div class="form-outline mb-4">
                            <input type="text" id="uname" name="uname" class="form-control" value="<?= $username ?>" required />
                            <label class="form-label" for="uname">Username</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="email" id="email" name="email" class="form-control" placeholder="example@gmail.com" value="<?= $email ?>" required />
                            <label class="form-label" for="email">Email</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="pass" name="pass" class="form-control" value="<?= $password ?>" required />
                            <label class="form-label" for="pass">Password</label>
                            <div class="invalid-feedback">
                                Password must be at least 8 characters long, contain at least one uppercase, and one number.
                            </div>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="password" id="cpass" name="cpass" class="form-control" value="<?= $confirm_password ?>" required />
                            <label class="form-label" for="cpass">Re-enter Password</label>
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <input type="submit" class="btn btn-primary btn-block mb-4 mt-4" value="Enroll Now" name="enroll">
            </form>
        </div>
    </div>

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
</body>

</html>