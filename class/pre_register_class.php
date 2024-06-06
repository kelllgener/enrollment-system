<?php 

require "dbConnection.php";

class PreRegisterConfig extends DbConfig {

    public $conn;

    public function __construct() {

        $this->conn = $this->getConnection();

    }

    public function selectUser($userid) {

        $sql = "SELECT * FROM vw_user_roles WHERE USER_ID = '$userid'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        return $row;
    }

    public function userLogin($username, $password) {

        $sql = "SELECT * FROM tbl_users WHERE USERNAME = '$username'";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();

        

        if(mysqli_num_rows($result) > 0) {
            $passwordHash = $row["PASSWORD"];

            if(password_verify($password, $passwordHash)) {
                $userid = $row["USER_ID"];

                $sql = "SELECT * FROM vw_user_roles WHERE USER_ID = '$userid'";
                $result = $this->conn->query($sql);
                $row_vw_roles = $result->fetch_assoc();

                //VIEW USER ROLES INFORMATION 
                $_SESSION["user_ID"] = $row_vw_roles["USER_ID"];
                $_SESSION["username"] = $row_vw_roles["USERNAME"];
                $_SESSION["email"] = $row_vw_roles["EMAIL"];
                $_SESSION["password"] = $row_vw_roles["PASSWORD"];
                $_SESSION["firstname"] = $row_vw_roles["FIRSTNAME"];
                $_SESSION["middlename"] = $row_vw_roles["MIDDLENAME"];
                $_SESSION["lastname"] = $row_vw_roles["LASTNAME"];
                $_SESSION["role"] = $row_vw_roles["ROLE"];
                $_SESSION["entrydate"] = $row_vw_roles["ENTRY_DATETIME"];
                
                return 1;

            }
            else {
                return 2;
            }
        }
        else {
            return 3;
        }
        
        $this->conn->close();
    }

    function insertStudent($lastname, $firstname, $middlename, $address, $sex, $birth_date, $place_of_birth, $age, $nationality, $religion, 
        $username, $email, $password, 
        $father_name, $father_occupation, 
        $mother_name, $mother_occupation, 
        $guardian_name, $relationship_id, $guardian_occupation, $contact_no,
        $confirm_password,
        $birth_cert) {


        $sqlValidation = "SELECT * FROM tbl_users WHERE USERNAME = ? OR EMAIL = ?";
        $stmtValidation = $this->conn->prepare($sqlValidation);
        $stmtValidation->bind_param("ss", $username, $email);
        $stmtValidation->execute();
        $resultValidation = $stmtValidation->get_result();
        
        if (mysqli_num_rows($resultValidation) > 0) {
            return 1;
        } 
        else if ($password == $confirm_password) {
            if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
                return 3;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
                return 4;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $middlename)) {
                return 5;
            } elseif (!preg_match('/^[0-9]*$/', $age)) {
                return 6;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $nationality)) {
                return 7;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $religion)) {
                return 8;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $mother_name)) {
                return 9;
            } elseif (!preg_match("/^[a-zA-Z ]*$/", $father_name)) {
                return 10;
            } elseif (!preg_match('/^[0-9]*$/', $contact_no)) {
                return 11;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 12;
            } else {
                // Hash Password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                // Start Transaction
                $this->conn->begin_transaction();

                date_default_timezone_set('Asia/Manila');
                $currentDateTime = date("Y-m-d H:i:s");

                $profile = "profile.jpg";

                // Hash Password
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);


                // Insert users into table    
                $sql = "INSERT INTO tbl_users (USERNAME, PASSWORD, EMAIL, PROFILE, ENTRY_DATETIME) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("sssss", $username, $passwordHash, $email, $profile, $currentDateTime);
            
                // Get the USER_ID of the newly inserted user 
                if ($stmt->execute()) {
                    $userID = $this->conn->insert_id;
                    $studentRole = 3;

                    $sqlRole = "INSERT INTO tbl_user_roles (USER_ID, ROLE_ID) VALUES (?, ?)";
                    $stmtRole = $this->conn->prepare($sqlRole);
                    $stmtRole->bind_param("ii", $userID, $studentRole);

                    if (!$stmtRole->execute()) {
                        // Rollback the transaction if any role insertion fails
                        $this->conn->rollback();
                        return false;
                    }

                    $status_id = 301;
                    $section_id = 3;

                    // Use placeholders in the SQL queries
                    $sqlStudent = "INSERT INTO tbl_student_info (USER_ID, LASTNAME, FIRSTNAME, MIDDLENAME, ADDRESS, SEX, BIRTH_DATE, PLACE_OF_BIRTH, AGE, NATIONALITY, RELIGION, STATUS_ID, SECTION_ID, BIRTH_CERTIFICATE)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    // Binding parameters
                    $stmtStudent = $this->conn->prepare($sqlStudent);
                    $stmtStudent->bind_param("isssssssissiis", $userID, $lastname, $firstname, $middlename, $address, $sex, $birth_date, $place_of_birth, $age, $nationality, $religion, $status_id, $section_id, $targetFile);
                    // File Upload
                    $targetDirectory = "../certificate/";
                    $targetFile = $targetDirectory . basename($birth_cert);
                    move_uploaded_file($_FILES['birth_cert']['tmp_name'], $targetDirectory . $targetFile);
                    
                    if (!$stmtStudent->execute()) {
                        // Rollback the transaction if info insertion fails
                        $this->conn->rollback();
                        return false;
                    }

                    $sqlFather = "INSERT INTO tbl_father (FATHER_ID, FATHER_NAME, FATHER_OCCUPATION) VALUES (?, ?, ?)";
                    $stmtFather = $this->conn->prepare($sqlFather);
                    $stmtFather->bind_param("iss", $userID, $father_name, $father_occupation);

                    if (!$stmtFather->execute()) {
                        // Rollback the transaction if any role insertion fails
                        $this->conn->rollback();
                        return false;
                    }

                    $sqlMother = "INSERT INTO tbl_mother (MOTHER_ID, MOTHER_NAME, MOTHER_OCCUPATION) VALUES (?, ?, ?)";
                    $stmtsqlMother = $this->conn->prepare($sqlMother);
                    $stmtsqlMother->bind_param("iss", $userID ,$mother_name, $mother_occupation);

                    if (!$stmtsqlMother->execute()) {
                        // Rollback the transaction if any role insertion fails
                        $this->conn->rollback();
                        return false;
                    }

                    $sqlGuardian = "INSERT INTO tbl_guardian (GUARDIAN_ID, GUARDIAN_NAME, RELATIONSHIP_ID, GUARDIAN_OCCUPATION, CONTACT_NO) VALUES (?, ?, ?, ?, ?)";
                    $stmtsqlGuardian = $this->conn->prepare($sqlGuardian);
                    $stmtsqlGuardian->bind_param("isiss", $userID, $guardian_name, $relationship_id, $guardian_occupation, $contact_no);

                    if (!$stmtsqlGuardian->execute()) {
                        // Rollback the transaction if any role insertion fails
                        $this->conn->rollback();
                        return false;
                    }


                    // Commit the transaction if everything is successful
                    $this->conn->commit();
                    return 2;
                    return true;

                
                } else {
                    // Rollback the transaction if user insertion fails
                    $this->conn->rollback();
                    return false;
                }

            }
        } 
        else {
            return 13;
        }
       
    }

    public function searchforForgotAccount($username, $email) {
    
        $sql = "SELECT * FROM tbl_users WHERE USERNAME = ? and Email = ?";
        $stmt_find = $this->conn->prepare($sql);
        $stmt_find->bind_param("ss", $username, $email);
        $stmt_find->execute();
        $result_find = $stmt_find->get_result();

            if ($result_find) {
                while ($row = $result_find->fetch_assoc()) {
                    $_SESSION["username_for_recover"] = $row["USERNAME"];
                    $_SESSION["email_for_recover"] = $row["EMAIL"];
            
                    header("Location: recover_password.php");
                    return 1;
                }
            } 
        else {
          return 2;
    
        }
    }

    public function reset_password($password, $confirmpass, $username, $email) {

        // Start Transaction
        $this->conn->begin_transaction();

        if ($password === $confirmpass) {

            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE tbl_users SET PASSWORD = ? where USERNAME = ? and EMAIL = ?";
            $stmt_recover = $this->conn->prepare($sql);
            $stmt_recover->bind_param("sss", $passwordHashed, $username, $email);
            

            if (!$stmt_recover->execute()) {
                // Rollback the transaction if any role insertion fails
                $this->conn->rollback();
                return false;
            }

        }
        else {
            // Rollback the transaction if user insertion fails
            $this->conn->rollback();
            return false;
        }

        // Commit the transaction if everything is successful
        $this->conn->commit();
        return 1;
        return true;

  }


}


?>