<?php 

require_once "pre_register_class.php";

class UserAccount extends PreRegisterConfig {
		
    public function displayUserAccount() {

		// get page number
		if(isset($_GET["page_no"]) && $_GET["page_no"] !== "") {
			$page_no = $_GET["page_no"];
		}
		else {
			$page_no = 1;
		}
		// total rows or records to display 
		$total_records_per_page = 10;
		// get the page offset for the LIMIT query 
		$offset = ($page_no - 1) *$total_records_per_page;

		$previous_page = $page_no - 1;
		$next_page = $page_no + 1;

		$result_count = mysqli_query($this->conn, "SELECT COUNT(*) AS total_records FROM vw_user_roles") or die($this->conn);
		$records = mysqli_fetch_array($result_count);
		$total_records = $records["total_records"];
		$total_no_of_pages = ceil($total_records / $total_records_per_page);

        $sql = "SELECT  * FROM vw_user_roles LIMIT $offset, $total_records_per_page";
		$result = $this->getConnection()->query($sql);
		if (!$result) {
		die("Invalid Query: " . $this->getConnection()->connect_error);
		}

		$_SESSION['page_no'] = $page_no;
        $_SESSION['total_records_per_page'] = $total_records_per_page;
        $_SESSION['offset'] = $offset;

		$_SESSION['prev_page'] = $previous_page;
        $_SESSION['next_page'] = $next_page;
        $_SESSION['result_count'] = $result_count;
		$_SESSION['records'] = $records;
        $_SESSION['total_records'] = $total_records;
        $_SESSION['total_no_of_pages'] = $total_no_of_pages;

		return $result;
    }

	public function searchUserAccount() {

		$search = $_POST["txtSearch"];
		// get page number
		if(isset($_GET["page_no"]) && $_GET["page_no"] !== "") {
			$page_no = $_GET["page_no"];
		}
		else {
			$page_no = 1;
		}
		// total rows or records to display 
		$total_records_per_page = 10;
		// get the page offset for the LIMIT query 
		$offset = ($page_no - 1) *$total_records_per_page;
	
		$sql = "SELECT * from vw_user_roles 
		where concat(USER_ID, FIRSTNAME, LASTNAME, USERNAME, EMAIL, ROLE)
		like '%$search%'
		LIMIT $offset, $total_records_per_page";

		$result = $this->getConnection()->query($sql);
	
		if (!$result) {
			die("Invalid Query: " . $this->getConnection()->connect_error);
		}
		return $result;

		
	}

    public function displayProfile() {

        $sql = "select profile from vw_user_roles where USER_ID = '$_SESSION[user_ID]'";
        $result = $this->conn->query($sql);

        if (!$result) {
			die("Invalid Query: " . $this->conn->connect_error);
        }

        while ($row = $result->fetch_assoc()) {
			echo "../profiles/$row[PROFILE]";
        }
    }

	function display_user_account_row_count() {
		$sql = "SELECT * from tbl_users";
		$result = mysqli_query($this->getConnection(), $sql);
	
		if ($total_row = mysqli_num_rows($result)) {
			echo $total_row;
		} else {
			echo " No data";
		}
	}

	public function update_user_passwords($currentpass, $newpassword, $reenterpass) {
	
		$userid = $_SESSION["user_ID"];
		
		$sql_verify = "SELECT * from tbl_users WHERE USER_ID = ?";
		$stmt_verify = $this->conn->prepare($sql_verify);
		$stmt_verify->bind_param("i", $userid);
		$stmt_verify->execute();
		$result_verify = $stmt_verify->get_result();
		$result_row = $result_verify->fetch_assoc();

		$passwordHash = $result_row["PASSWORD"];

		if (password_verify($currentpass, $passwordHash)) {
			
			if($newpassword == $reenterpass) {
				$passwordHashed = password_hash($newpassword, PASSWORD_DEFAULT);

				$sql = "UPDATE tbl_users SET PASSWORD = ? where USER_ID = ?";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("si", $passwordHashed ,$userid);

				if (!$stmt->execute()) {
					die("Invalid Query: " . $this->getConnection()->connect_error);
				}
				else {
					return 1;
				}
			}
			else {
				return 2;
			}
		}
		else {
			return 3;
		}
	
	
	  }


	function registerUser($firstname, $lastname, $middlename, $username, $password, $confirm_password, $email, $roles) {
    

		$sqlValidation = "SELECT * FROM tbl_users WHERE USERNAME = ? OR EMAIL = ?";
        $stmtValidation = $this->conn->prepare($sqlValidation);
        $stmtValidation->bind_param("ss", $username, $email);
        $stmtValidation->execute();
        $resultValidation = $stmtValidation->get_result();

		if (mysqli_num_rows($resultValidation) > 0) {
			return 1;
		}
		else if ($password == $confirm_password) {

			if(!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
				return 3;
				}
				elseif(!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
				return 4;
				}
				elseif(!preg_match("/^[a-zA-Z ]*$/", $middlename)) {
				return 7;
				}
				elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				return 5;
				}
				else {
				// Hash Password
				$passwordHash = password_hash($password, PASSWORD_DEFAULT);

				// Start Transaction
				$this->conn->begin_transaction();

				date_default_timezone_set('Asia/Manila');
				$currentDateTime = date("Y-m-d H:i:s");
				$profile = "profile.jpg";
			
				// Insert users into table    
				$sql = "INSERT INTO tbl_users (USERNAME, PASSWORD, EMAIL, PROFILE, ENTRY_DATETIME) VALUES (?, ?, ?, ?, ?)";
				$stmt = $this->conn->prepare($sql);
				$stmt->bind_param("sssss", $username, $passwordHash, $email, $profile, $currentDateTime);
			
				// Get the USER_ID of the newly inserted user 
				if ($stmt->execute()) {
					$userID = $this->conn->insert_id;
			
					// Insert Roles into UserRoles Table
					foreach ($roles as $role) {
						$sqlRole = "INSERT INTO tbl_user_roles (USER_ID, ROLE_ID) VALUES (?, (SELECT ROLE_ID FROM tbl_roles WHERE ROLE_NAME = ?))";
						$stmtRole = $this->conn->prepare($sqlRole);
						$stmtRole->bind_param("is", $userID, $role);
			
						if (!$stmtRole->execute()) {
							// Rollback the transaction if any role insertion fails
							$this->conn->rollback();
							return false;
						}
					}
			
					// Check roles after inserting into tbl_user_roles
					$sqlCheckRoles = "SELECT ROLE_ID FROM tbl_user_roles WHERE USER_ID = ?";
					$stmtCheckRoles = $this->conn->prepare($sqlCheckRoles);
					$stmtCheckRoles->bind_param("i", $userID);
					$stmtCheckRoles->execute();
					$resultRoles = $stmtCheckRoles->get_result();
			
					// Insert data into corresponding tables based on roles
					while ($rowRole = $resultRoles->fetch_assoc()) {
						$roleId = $rowRole["ROLE_ID"];
			
						if ($roleId == 1) {
							$sqlAdmin = "INSERT INTO tbl_admin_info (USER_ID, FIRSTNAME, LASTNAME, MIDDLENAME) VALUES (?, ?, ?, ?)";
							$stmtAdmin = $this->conn->prepare($sqlAdmin);
							$stmtAdmin->bind_param("isss", $userID, $firstname, $lastname, $middlename);
			
							if (!$stmtAdmin->execute()) {
								// Rollback the transaction if info insertion fails
								$this->conn->rollback();
								return false;
							}
						} elseif ($roleId == 2) {
							$sqlTeacher = "INSERT INTO tbl_teacher_info (USER_ID, FIRSTNAME, LASTNAME, MIDDLENAME) VALUES (?, ?, ?, ?)";
							$stmtTeacher = $this->conn->prepare($sqlTeacher);
							$stmtTeacher->bind_param("isss", $userID, $firstname, $lastname, $middlename);
			
							if (!$stmtTeacher->execute()) {
								// Rollback the transaction if info insertion fails
								$this->conn->rollback();
								return false;
							}
						}
						// Add additional elseif clauses for other roles if needed
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
			return 6;
		}

    }

	public function deleteUseraccount($userID) {
		
		$stmt = $this->conn->prepare("DELETE FROM tbl_users WHERE USER_ID = ?");
		$stmt->bind_param("i", $userID);
	
		if ($stmt->execute()) {
			$stmt->close();
			
			header("location: ../admin/user_account.php?delete_by_id=success");
			exit; 
			
		} else {
			echo "Error: " . $stmt->error;
		}
	
		$this->conn->close();
	}

	public function selectUserToUpdate($userID) {

		$sqlSelect = "SELECT * FROM vw_user_roles WHERE USER_ID = ?";
		$stmtSelect = $this->conn->prepare($sqlSelect);
		$stmtSelect->bind_param("i", $userID);
		$stmtSelect->execute();
		$resultSelect = $stmtSelect->get_result();

		while ($rowSelect =$resultSelect->fetch_assoc()) {
			if(!$rowSelect) {
				header("location: ../admin/user_account.php");
				exit;
			}

			return $rowSelect;

		}

	}

	

	public function updateUser($userID, $firstname, $lastname, $username, $email, $profile) {

		$this->conn->begin_transaction();
	
		// Check roles to update
		$sqlCheckRoles = "SELECT ROLE_ID FROM tbl_user_roles WHERE USER_ID = ?";
		$stmtCheckRoles = $this->conn->prepare($sqlCheckRoles);
		$stmtCheckRoles->bind_param("i", $userID);
		$stmtCheckRoles->execute();
		$resultRoles = $stmtCheckRoles->get_result();

		// Check roles to update
		$sql_get_profile = "SELECT PROFILE FROM tbl_users WHERE USER_ID = ?";
		$stmt_get_profile = $this->conn->prepare($sql_get_profile);
		$stmt_get_profile->bind_param("i", $userID);
		$stmt_get_profile->execute();
		$result_profile = $stmt_get_profile->get_result();
		$row_profile = $result_profile->fetch_assoc();
	
		// Profile upload LOCATION
		$location = "../profiles/";
		$newFileUploaded = ($_FILES['profile']['error'] == 0);

		if($newFileUploaded) {
			$profile_value = $profile;
		}
		else {
			$profile_value = $row_profile["PROFILE"];
		}
	
		// Update tbl_users
		$sqlUser = "UPDATE tbl_users SET USERNAME = ?, EMAIL = ?, PROFILE = ? WHERE USER_ID = ?";
		$stmtUser = $this->conn->prepare($sqlUser);
		$stmtUser->bind_param("sssi", $username, $email, $profile_value, $userID);
	
		while ($rowRole = $resultRoles->fetch_assoc()) {
			$roleId = $rowRole["ROLE_ID"];
	
			// Update tbl_admin_info
			if ($roleId == 1) {
				$sql_update_admin = "UPDATE tbl_admin_info SET FIRSTNAME = ?, LASTNAME = ? WHERE USER_ID = ?";
				$stmt_update_admin = $this->conn->prepare($sql_update_admin);
				$stmt_update_admin->bind_param("ssi", $firstname, $lastname, $userID);
				$stmtUser->execute();
				move_uploaded_file($_FILES['profile']['tmp_name'], $location . $profile);
	
				if (!$stmt_update_admin->execute()) {
					// Rollback the transaction if info insertion fails
					$this->conn->rollback();
					return false;
				}
			}
			// Update tbl_teacher_info
			elseif ($roleId == 2) {
				$sql_update_teacher = "UPDATE tbl_teacher_info SET FIRSTNAME = ?, LASTNAME = ? WHERE USER_ID = ?";
				$stmt_update_teacher = $this->conn->prepare($sql_update_teacher);
				$stmt_update_teacher->bind_param("ssi", $firstname, $lastname, $userID);
				$stmtUser->execute();
				move_uploaded_file($_FILES['profile']['tmp_name'], $location . $profile);
	
				if (!$stmt_update_teacher->execute()) {
					// Rollback the transaction if info insertion fails
					$this->conn->rollback();
					return false;
				}
			}
			elseif ($roleId == 3) {
				$sql_update_student = "UPDATE tbl_student_info SET FIRSTNAME = ?, LASTNAME = ? WHERE USER_ID = ?";
				$stmt_update_student = $this->conn->prepare($sql_update_student);
				$stmt_update_student->bind_param("ssi", $firstname, $lastname, $userID);
				$stmtUser->execute();
				move_uploaded_file($_FILES['profile']['tmp_name'], $location . $profile);
	
				if (!$stmt_update_student->execute()) {
					// Rollback the transaction if info insertion fails
					$this->conn->rollback();
					return false;
				}
			}
	
			// Commit the transaction after each role update
			$this->conn->commit();
	
			return 1;
		}
	
		// If the loop completes without returning, commit the transaction
		$this->conn->commit();
		return true;
	}
	
	function display_user_count() {

        $sql = "SELECT * FROM vw_role_sum";
        $result = $this->getConnection()->query($sql);
        if($result) {
            while($row = $result->fetch_assoc()) {
                echo "['".$row['role_name']."',".$row['role_count']."],";
            }
        }
	}

	function display_section_count() {

        $sql = "SELECT * FROM vw_section_count";
        $result = $this->getConnection()->query($sql);

		if($result) {
			while($row = $result->fetch_assoc()) {
				echo "['".$row['section_name']."',".$row['section_count']."],";
			}
		}
	}

	public function convert_to_csv_system_users() {

		$sql = "SELECT * FROM vw_user_roles";
		$result = $this->getConnection()->query($sql);

		if ($result->num_rows > 0) {
		$delimiter = ",";
		$filename = "System_Users_" . date('Y-m-d') . ".csv";

		$f = fopen('php://memory', 'w');

		$fields = array('USER_ID', 'LASTNAME', 'FIRSTNAME', 'MIDDLENAME', 'USERNAME', 'EMAIL', 'ROLE', 'ENTRY_DATETIME');
		fputcsv($f, $fields, $delimiter);

		while ($row = $result->fetch_assoc()) {
			$lineData = array($row['USER_ID'], $row['LASTNAME'], $row['FIRSTNAME'], $row['MIDDLENAME'], $row['USERNAME'], $row['EMAIL'], $row['ROLE'], $row['ENTRY_DATETIME']);
			fputcsv($f, $lineData, $delimiter);
		}

		fseek($f, 0);

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename ="' . $filename . '";');

		fpassthru($f);
		}
		exit;
	}	
	
	
}


?>